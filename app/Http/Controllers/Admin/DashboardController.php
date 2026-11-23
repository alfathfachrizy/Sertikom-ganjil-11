<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SchoolSubmission;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalOrders = Order::count();
        $paidOrders = Order::where('status', Order::STATUS_PAID)->count();
        $pendingSubmissions = SchoolSubmission::where('status', SchoolSubmission::STATUS_PENDING)->count();
        $totalRevenue = Order::where('status', Order::STATUS_PAID)->sum('total_amount');

        return view('admin.dashboard', compact(
            'totalOrders',
            'paidOrders',
            'pendingSubmissions',
            'totalRevenue',
        ));
    }
}
