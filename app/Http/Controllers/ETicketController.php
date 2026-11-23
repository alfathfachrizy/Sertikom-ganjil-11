<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ETicketController extends Controller
{
    public function show(Order $order): View
    {
        Gate::authorize('viewETicket', $order);
        $order->load(['user', 'eTicket', 'items.ticket', 'items.schoolPackage']);
        abort_unless($order->eTicket, 404);

        return view('etickets.show', compact('order'));
    }
}
