<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create() { return view('admin.products.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'=>'required|string|max:255',
            'stok'=>'required|integer|min:0',
            'harga'=>'required|integer|min:0',
            'satuan'=>'nullable|string|max:50',
            'deskripsi'=>'nullable|string',
        ]);

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success','Produk ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'nama'=>'required|string|max:255',
            'stok'=>'required|integer|min:0',
            'harga'=>'required|integer|min:0',
            'satuan'=>'nullable|string|max:50',
            'deskripsi'=>'nullable|string',
        ]);

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success','Produk diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success','Produk dihapus.');
    }
}
