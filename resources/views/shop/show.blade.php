@extends('layouts.store')
@section('content')

<div class="rounded-3xl border bg-white p-8">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <div class="text-3xl font-black">{{ $product->nama }}</div>
      <div class="text-slate-500 mt-1">Stok: {{ $product->stok }} {{ $product->satuan }}</div>
    </div>
    <div class="text-3xl font-black">Rp {{ number_format($product->harga,0,',','.') }}</div>
  </div>

  @if($product->deskripsi)
    <div class="mt-4 text-slate-700">{{ $product->deskripsi }}</div>
  @endif

  <div class="mt-6 flex flex-wrap gap-3">
    <a href="{{ route('shop.index') }}" class="rounded-2xl border px-5 py-3 hover:bg-slate-100">Kembali</a>

    <form method="POST" action="{{ route('cart.add',$product) }}" class="flex gap-2">
      @csrf
      <input type="number" name="qty" min="1" max="{{ $product->stok }}" value="1"
             class="w-28 rounded-2xl border px-4 py-3" />
      <button class="rounded-2xl bg-indigo-600 text-white px-5 py-3 font-semibold hover:opacity-90">
        + Keranjang
      </button>
    </form>
  </div>
</div>

@endsection
