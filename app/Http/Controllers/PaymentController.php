<?php

namespace App\Http\Controllers;

use App\Models\ETicket;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction;
use Throwable;

class PaymentController extends Controller
{
    private function configureMidtrans(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function pay(Order $order): View
    {
        Gate::authorize('pay', $order);
        $this->configureMidtrans();

        $payment = Payment::where('order_id', $order->id)
            ->where('transaction_status', 'pending')
            ->latest()
            ->first();

        if (! $payment) {
            $payment = Payment::create([
                'order_id' => $order->id,
                'midtrans_order_id' => $order->order_code.'-'.time(),
                'snap_token' => null,
                'gross_amount' => $order->total_amount,
                'transaction_status' => 'pending',
            ]);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $payment->midtrans_order_id,
                'gross_amount' => (int) round((float) $order->total_amount),
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone,
            ],
        ];

        $payment->update([
            'snap_token' => Snap::getSnapToken($params),
        ]);

        return view('payments.pay', [
            'order' => $order,
            'payment' => $payment,
            'clientKey' => config('midtrans.client_key'),
        ]);
    }

    public function notification(Request $request): JsonResponse
    {
        $this->configureMidtrans();

        $notification = new Notification;
        $payment = Payment::where('midtrans_order_id', $notification->order_id)->first();

        if (! $payment) {
            abort(404, 'Pembayaran tidak ditemukan.');
        }

        $this->syncPayment(
            $payment,
            (string) $notification->transaction_status,
            $notification->payment_type ?? null,
            $notification->fraud_status ?? null,
        );

        return response()->json(['ok' => true]);
    }

    public function finish(Order $order): RedirectResponse
    {
        Gate::authorize('view', $order);
        $this->configureMidtrans();

        $payment = $order->payments()->latest()->first();
        if (! $payment) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Data pembayaran belum tersedia.');
        }

        try {
            $status = Transaction::status($payment->midtrans_order_id);
            $this->syncPayment(
                $payment,
                (string) $status->transaction_status,
                $status->payment_type ?? null,
                $status->fraud_status ?? null,
            );
        } catch (Throwable $exception) {
            report($exception);

            return redirect()->route('orders.show', $order)
                ->with('error', 'Gagal menghubungi Midtrans. Silakan coba kembali beberapa saat lagi.');
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    private function syncPayment(Payment $payment, string $status, ?string $type, ?string $fraudStatus = null): void
    {
        DB::transaction(function () use ($payment, $status, $type, $fraudStatus): void {
            $payment->update([
                'transaction_status' => $status,
                'payment_type' => $type,
            ]);

            $order = $payment->order()->lockForUpdate()->firstOrFail();

            if ($status === 'settlement' || ($status === 'capture' && $fraudStatus === 'accept')) {
                $order->update([
                    'status' => Order::STATUS_PAID,
                ]);
                $payment->update(['paid_at' => now()]);

                ETicket::firstOrCreate(
                    ['order_id' => $order->id],
                    [
                        'ticket_code' => 'ET-'.strtoupper(Str::random(10)),
                        'issued_at' => now(),
                    ],
                );
            } elseif ($status === 'expire') {
                $order->update(['status' => Order::STATUS_EXPIRED]);
            } elseif (in_array($status, ['cancel', 'deny'], true)) {
                $order->update(['status' => Order::STATUS_CANCELLED]);
            }
        });
    }
}
