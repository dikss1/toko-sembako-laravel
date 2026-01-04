<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function cart(): array {
        return session()->get('cart', []);
    }

    private function save(array $cart): void {
        session()->put('cart', $cart);
    }

    public function index()
    {
        $cart = $this->cart();
        $items = [];
        $subtotal = 0;

        foreach ($cart as $productId => $qty) {
            $p = Product::find($productId);
            if (!$p) continue;

            $qty = min((int)$qty, (int)$p->stok); // clamp biar gak bisa > stok
            $line = $p->harga * $qty;

            $items[] = compact('p','qty','line');
            $subtotal += $line;
        }

        return view('cart.index', compact('items','subtotal'));
    }

    public function add(Request $request, Product $product)
    {
        $qty = max(1, (int) $request->input('qty', 1));
        $qty = min($qty, (int)$product->stok);

        $cart = $this->cart();
        $cart[$product->id] = min(($cart[$product->id] ?? 0) + $qty, (int)$product->stok);
        $this->save($cart);

        return back()->with('success', 'Produk masuk keranjang.');
    }

    public function update(Request $request, Product $product)
    {
        $qty = max(1, (int) $request->input('qty', 1));
        $qty = min($qty, (int)$product->stok);

        $cart = $this->cart();
        $cart[$product->id] = $qty;
        $this->save($cart);

        return back()->with('success','Keranjang diperbarui.');
    }

    public function remove(Product $product)
    {
        $cart = $this->cart();
        unset($cart[$product->id]);
        $this->save($cart);

        return back()->with('success','Item dihapus.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success','Keranjang dikosongkan.');
    }
}
