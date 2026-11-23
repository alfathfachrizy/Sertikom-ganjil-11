<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TicketOrderController extends Controller
{
    public function create(Ticket $ticket): View
    {
        abort_unless($ticket->is_active, 404);

        return view('ticket-orders.create', compact('ticket'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ticket_id' => ['required', 'exists:tickets,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:50'],
            'visit_date' => ['required', 'date', 'after_or_equal:today'],
        ], [
            'ticket_id.required' => 'Tiket wajib dipilih.',
            'ticket_id.exists' => 'Tiket tidak ditemukan.',
            'quantity.required' => 'Jumlah tiket wajib diisi.',
            'quantity.integer' => 'Jumlah tiket harus berupa angka.',
            'quantity.min' => 'Jumlah tiket minimal 1.',
            'quantity.max' => 'Jumlah tiket maksimal 50.',
            'visit_date.required' => 'Tanggal kunjungan wajib diisi.',
            'visit_date.after_or_equal' => 'Tanggal kunjungan tidak boleh sebelum hari ini.',
        ]);

        $ticket = Ticket::findOrFail($validated['ticket_id']);
        abort_unless($ticket->is_active, 404);

        $order = DB::transaction(function () use ($ticket, $validated): Order {
            $subtotal = $ticket->price * $validated['quantity'];

            $orderCode = 'TNP-'.strtoupper(Str::random(8));
            while (Order::where('order_code', $orderCode)->exists()) {
                $orderCode = 'TNP-'.strtoupper(Str::random(8));
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => $orderCode,
                'order_type' => Order::TYPE_GENERAL,
                'visit_date' => $validated['visit_date'],
                'total_amount' => $subtotal,
                'status' => Order::STATUS_AWAITING_PAYMENT,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'ticket_id' => $ticket->id,
                'school_package_id' => null,
                'quantity' => $validated['quantity'],
                'unit_price' => $ticket->price,
                'subtotal' => $subtotal,
            ]);

            return $order;
        });

        return redirect()->route('payments.pay', $order)
            ->with('success', 'Pesanan tiket berhasil dibuat.');
    }
}
