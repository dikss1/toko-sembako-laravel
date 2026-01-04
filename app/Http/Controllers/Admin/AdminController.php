<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer','user')
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('customer','user','items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function verifyPayment(Order $order)
    {
        // admin set paid
        $order->update([
            'payment_status' => 'paid',
            'status' => $order->status === 'pending' ? 'processing' : $order->status,
        ]);

        return back()->with('success','Pembayaran tervalidasi.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required','in:pending,processing,shipped,done,cancelled'],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success','Status order diperbarui.');
    }
}
