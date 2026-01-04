@extends('layouts.app')
@section('content')

<div class="flex items-center justify-between mb-4">
  <div>
    <h1 class="text-2xl font-bold">Master Produk</h1>
    <p class="text-slate-500 text-sm">Kelola data produk.</p>
  </div>
  <a href="{{ route('products.create') }}" class="rounded-xl bg-indigo-600 text-white px-4 py-2 font-semibold hover:opacity-90">+ Tambah</a>
</div>

<div class="rounded-2xl border bg-white overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-slate-50 text-slate-600">
      <tr>
        <th class="text-left px-4 py-3">Nama</th>
        <th class="text-left px-4 py-3 w-40">Harga</th>
        <th class="text-left px-4 py-3 w-24">Stok</th>
        <th class="text-left px-4 py-3 w-40">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $p)
      <tr class="border-t">
        <td class="px-4 py-3 font-semibold">{{ $p->nama }}</td>
        <td class="px-4 py-3">Rp {{ number_format($p->harga,0,',','.') }}</td>
        <td class="px-4 py-3">{{ $p->stok }}</td>
        <td class="px-4 py-3 flex gap-2">
          <a class="px-3 py-1 rounded-lg border hover:bg-slate-50" href="{{ route('products.edit',$p) }}">Edit</a>
          <form method="POST" action="{{ route('products.destroy',$p) }}" onsubmit="return confirm('Hapus produk?')">
            @csrf @method('DELETE')
            <button class="px-3 py-1 rounded-lg border hover:bg-slate-50">Hapus</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-4">{{ $products->links() }}</div>
@endsection
