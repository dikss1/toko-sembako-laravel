@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Produk</h1>

<div class="rounded-2xl border bg-white p-6 max-w-xl">
  <form method="POST" action="{{ route('products.update',$product) }}" class="space-y-4">
    @csrf @method('PUT')

    <div>
      <label class="text-sm font-semibold">Nama</label>
      <input name="nama" value="{{ old('nama',$product->nama) }}" class="w-full rounded-xl border px-3 py-2" required>
      @error('nama') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="text-sm font-semibold">Harga</label>
        <input type="number" name="harga" min="0" value="{{ old('harga',$product->harga) }}" class="w-full rounded-xl border px-3 py-2" required>
        @error('harga') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="text-sm font-semibold">Stok</label>
        <input type="number" name="stok" min="0" value="{{ old('stok',$product->stok) }}" class="w-full rounded-xl border px-3 py-2" required>
        @error('stok') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
      </div>
    </div>

    <div class="flex gap-2">
      <button class="rounded-xl bg-indigo-600 text-white px-4 py-2 font-semibold hover:opacity-90">Update</button>
      <a href="{{ route('products.index') }}" class="rounded-xl border px-4 py-2 hover:bg-slate-50">Batal</a>
    </div>
  </form>
</div>
@endsection
