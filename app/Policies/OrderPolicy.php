<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order): bool
    {
        return $user->isAdmin() || $order->user_id === $user->id;
    }

    public function pay(User $user, Order $order): bool
    {
        return $order->user_id === $user->id
            && $order->status === Order::STATUS_AWAITING_PAYMENT;
    }

    public function viewETicket(User $user, Order $order): bool
    {
        return ($user->isAdmin() || $order->user_id === $user->id)
            && $order->status === Order::STATUS_PAID;
    }
}
