<?php

namespace Database\Seeders;

use App\Models\ETicket;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\SchoolPackage;
use App\Models\SchoolSubmission;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::where('email', 'demo1@nicepark.test')->exists()) {
            return;
        }

        $admin = User::where('email', 'admin@nicepark.test')->firstOrFail();
        $tickets = Ticket::where('is_active', true)->orderBy('id')->get();
        $packages = SchoolPackage::where('is_active', true)->orderBy('id')->get();

        if ($tickets->isEmpty() || $packages->isEmpty()) {
            throw new \RuntimeException('Jalankan seeder tiket dan paket sekolah sebelum membuat data demo.');
        }

        DB::transaction(function () use ($admin, $tickets, $packages): void {
            $generalStatuses = [
                Order::STATUS_PAID,
                Order::STATUS_AWAITING_PAYMENT,
                Order::STATUS_EXPIRED,
                Order::STATUS_CANCELLED,
            ];
            $schoolStatuses = [
                Order::STATUS_PENDING_APPROVAL,
                Order::STATUS_AWAITING_PAYMENT,
                Order::STATUS_REJECTED,
                Order::STATUS_PAID,
            ];

            for ($customerNumber = 1; $customerNumber <= 15; $customerNumber++) {
                $customer = User::create([
                    'name' => 'Pelanggan Demo '.$customerNumber,
                    'email' => 'demo'.$customerNumber.'@nicepark.test',
                    'password' => Hash::make('password'),
                    'phone' => '0812345678'.str_pad((string) $customerNumber, 2, '0', STR_PAD_LEFT),
                ]);

                for ($generalNumber = 0; $generalNumber < 2; $generalNumber++) {
                    $ticket = $tickets[($customerNumber + $generalNumber - 1) % $tickets->count()];
                    $quantity = (($customerNumber + $generalNumber) % 4) + 1;
                    $status = $generalStatuses[($customerNumber + $generalNumber - 1) % count($generalStatuses)];
                    $subtotal = (int) $ticket->price * $quantity;
                    $order = Order::create([
                        'user_id' => $customer->id,
                        'order_code' => $this->uniqueOrderCode(),
                        'order_type' => Order::TYPE_GENERAL,
                        'visit_date' => now()->addDays((($customerNumber + $generalNumber) % 30) + 1)->toDateString(),
                        'total_amount' => $subtotal,
                        'status' => $status,
                    ]);

                    OrderItem::create([
                        'order_id' => $order->id,
                        'ticket_id' => $ticket->id,
                        'quantity' => $quantity,
                        'unit_price' => $ticket->price,
                        'subtotal' => $subtotal,
                    ]);

                    $this->createPaymentAndTicket($order, $status);
                }

                $package = $packages[($customerNumber - 1) % $packages->count()];
                $schoolStatus = $schoolStatuses[($customerNumber - 1) % count($schoolStatuses)];
                $participants = $package->min_participants + (($customerNumber % 5) * 2);
                $subtotal = (int) $package->price_per_participant * $participants;
                $schoolOrder = Order::create([
                    'user_id' => $customer->id,
                    'order_code' => $this->uniqueOrderCode(),
                    'order_type' => Order::TYPE_SCHOOL,
                    'visit_date' => now()->addDays((($customerNumber * 2) % 30) + 1)->toDateString(),
                    'total_amount' => $subtotal,
                    'status' => $schoolStatus,
                ]);

                OrderItem::create([
                    'order_id' => $schoolOrder->id,
                    'school_package_id' => $package->id,
                    'quantity' => $participants,
                    'unit_price' => $package->price_per_participant,
                    'subtotal' => $subtotal,
                ]);

                $submissionStatus = match ($schoolStatus) {
                    Order::STATUS_PENDING_APPROVAL => SchoolSubmission::STATUS_PENDING,
                    Order::STATUS_REJECTED => SchoolSubmission::STATUS_REJECTED,
                    default => SchoolSubmission::STATUS_APPROVED,
                };
                SchoolSubmission::create([
                    'order_id' => $schoolOrder->id,
                    'school_name' => 'Sekolah Demo '.$customerNumber,
                    'pic_name' => $customer->name,
                    'pic_phone' => $customer->phone,
                    'participant_count' => $participants,
                    'status' => $submissionStatus,
                    'rejection_reason' => $submissionStatus === SchoolSubmission::STATUS_REJECTED
                        ? 'Jadwal kunjungan tidak tersedia pada tanggal yang diajukan.'
                        : null,
                    'reviewed_by' => $submissionStatus === SchoolSubmission::STATUS_PENDING ? null : $admin->id,
                    'reviewed_at' => $submissionStatus === SchoolSubmission::STATUS_PENDING ? null : now(),
                ]);

                $this->createPaymentAndTicket($schoolOrder, $schoolStatus);
            }
        });
    }

    private function uniqueOrderCode(): string
    {
        do {
            $orderCode = 'TNP-'.strtoupper(Str::random(8));
        } while (Order::where('order_code', $orderCode)->exists());

        return $orderCode;
    }

    private function createPaymentAndTicket(Order $order, string $orderStatus): void
    {
        $paymentStatus = match ($orderStatus) {
            Order::STATUS_PAID => 'settlement',
            Order::STATUS_EXPIRED => 'expire',
            Order::STATUS_CANCELLED => 'cancel',
            default => 'pending',
        };

        if (! in_array($orderStatus, [
            Order::STATUS_PAID,
            Order::STATUS_AWAITING_PAYMENT,
            Order::STATUS_EXPIRED,
            Order::STATUS_CANCELLED,
        ], true)) {
            return;
        }

        $payment = Payment::create([
            'order_id' => $order->id,
            'midtrans_order_id' => 'DEMO-'.$order->order_code,
            'snap_token' => null,
            'payment_type' => $paymentStatus === 'settlement' ? 'bank_transfer' : null,
            'gross_amount' => $order->total_amount,
            'transaction_status' => $paymentStatus,
            'paid_at' => $paymentStatus === 'settlement' ? now() : null,
        ]);

        if ($paymentStatus === 'settlement') {
            ETicket::create([
                'order_id' => $order->id,
                'ticket_code' => 'ET-DEMO-'.strtoupper(Str::random(10)),
                'issued_at' => now(),
            ]);
        }
    }
}
