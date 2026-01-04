<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function profile()
    {
        $customer = auth()->user()->customer;
        return view('orders.profile', compact('customer'));
    }

    public function index()
    {
        $orders = Transaction::with('items.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (!$cart) return redirect()->route('shop.index')->withErrors(['msg'=>'Keranjang kosong.']);

        $customer = auth()->user()->customer;
        if (!$customer) return redirect()->route('orders.profile')->withErrors(['msg'=>'Lengkapi profil dulu.']);

        // build items preview
        $items = [];
        $subtotal = 0;
        foreach ($cart as $id => $qty) {
            $p = Product::find($id);
            if (!$p) continue;

            $qty = min((int)$qty, (int)$p->stok);
            $line = $p->harga * $qty;
            $items[] = compact('p','qty','line');
            $subtotal += $line;
        }

        return view('orders.checkout', compact('items','subtotal','customer'));
    }

    public function place(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required|in:pickup,delivery',
        ]);

        $shipping = $request->delivery_method === 'delivery' ? 10000 : 0;

        $cart = session()->get('cart', []);
        if (!$cart) return back()->withErrors(['msg'=>'Keranjang kosong.']);

        $user = auth()->user();
        $customer = $user->customer;

        return DB::transaction(function () use ($cart, $user, $customer, $shipping, $request) {

            $trx = Transaction::create([
                'kode' => 'ORD-' . strtoupper(Str::random(8)),
                'user_id' => $user->id,
                'customer_id' => $customer->id,
                'tanggal' => now()->toDateString(),
                'delivery_method' => $request->delivery_method,
                'shipping_fee' => $shipping,
                'subtotal' => 0,
                'total' => 0,
                'payment_status' => 'unpaid',
                'status' => 'menunggu_pembayaran',
            ]);

            $subtotal = 0;

            foreach ($cart as $productId => $qty) {
                $product = Product::lockForUpdate()->findOrFail($productId);

                // qty maksimum = stok
                $qty = max(1, (int)$qty);
                $max = (int)$product->stok;
                if ($qty > $max) {
                    return back()->withErrors([
                        'msg' => "Stok {$product->nama} tidak cukup. Maksimal yang bisa dibeli: {$max}."
                    ]);
                }

                $harga = (int)$product->harga;
                $line = $harga * $qty;

                TransactionItem::create([
                    'transaction_id' => $trx->id,
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'harga' => $harga,
                    'subtotal' => $line,
                ]);

                $product->decrement('stok', $qty);
                $subtotal += $line;
            }

            $total = $subtotal + $shipping;

            $trx->update([
                'subtotal' => $subtotal,
                'total' => $total,
            ]);

            session()->forget('cart');

            return redirect()->route('orders.pay', $trx)->with('success','Pesanan dibuat. Silakan bayar via QRIS.');
        });
    }

    public function pay(Transaction $order)
    {
        $this->authorizeOwner($order);
        return view('orders.pay', compact('order'));
    }

    public function uploadProof(Request $request, Transaction $order)
    {
        $this->authorizeOwner($order);

        $request->validate([
            'proof' => 'required|image|max:2048',
        ]);

        $path = $request->file('proof')->store('payment_proofs', 'public');

        $order->update([
            'payment_proof_path' => $path,
            'payment_status' => 'waiting_confirm',
        ]);

        return back()->with('success','Bukti pembayaran diupload. Menunggu validasi admin.');
    }

    public function show(Transaction $order)
    {
        $this->authorizeOwner($order);
        $order->load('items.product','customer');
        return view('orders.show', compact('order'));
    }

    public function invoice(Transaction $order)
    {
        $this->authorizeOwner($order);
        $order->load('items.product','customer');
        return view('orders.invoice', compact('order'));
    }

    private function authorizeOwner(Transaction $order): void
    {
        if ($order->user_id !== auth()->id()) abort(403);
    }
}
