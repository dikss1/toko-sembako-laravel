<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Transaction::count();
        $waitingConfirm = Transaction::where('payment_status','waiting_confirm')->count();
        $products = Product::count();

        return view('admin.dashboard', compact('totalOrders','waitingConfirm','products'));
    }
}
