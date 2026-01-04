<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Transaction::with('customer','items.product')
            ->latest()
            ->paginate(12);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Transaction $order)
    {
        $order->load('customer','user','items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function markPaid(Transaction $order)
    {
        $order->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
            'status' => 'diproses',
        ]);

        return back()->with('success','Pembayaran divalidasi. Status: Diproses.');
    }

    public function updateStatus(Request $request, Transaction $order)
    {
        $request->validate([
            'status' => 'required|in:diproses,dikirim,selesai,dibatalkan,menunggu_pembayaran',
        ]);

        // rule sederhana: kalau belum paid, jangan bisa jadi dikirim/selesai
        if ($order->payment_status !== 'paid' && in_array($request->status, ['dikirim','selesai'])) {
            return back()->withErrors(['msg'=>'Tidak bisa mengirim/selesai sebelum pembayaran paid.']);
        }

        $order->update(['status' => $request->status]);
        return back()->with('success','Status pesanan diperbarui.');
    }
}
