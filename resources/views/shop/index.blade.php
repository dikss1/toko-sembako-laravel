@extends('layouts.store')
@section('content')

<div class="rounded-3xl bg-gradient-to-r from-indigo-700 via-fuchsia-600 to-rose-500 p-8 text-white">
  <div class="text-3xl font-black">Belanja Sembako Online</div>
  <div class="mt-2 text-white/80">Cepat • Mudah • Bayar QRIS • Bisa Diantar</div>
  <div class="mt-6 flex flex-wrap gap-3">
    <a href="{{ route('cart.index') }}" class="rounded-2xl bg-white text-slate-900 px-5 py-3 font-black">Lihat Keranjang</a>
    @auth
      @if(auth()->user()->role === 'customer')
        <a href="{{ route('orders.index') }}" class="rounded-2xl bg-white/15 px-5 py-3 font-semibold hover:bg-white/25">Pesanan Saya</a>
      @endif
    @else
      <a href="{{ route('register') }}" class="rounded-2xl bg-white/15 px-5 py-3 font-semibold hover:bg-white/25">Daftar & Belanja</a>
    @endauth
  </div>
</div>

<div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
  @foreach($products as $p)
    <div class="rounded-3xl border bg-white p-6 shadow-sm">
      <div class="font-black text-lg">{{ $p->nama }}</div>
      <div class="text-sm text-slate-500">Stok: {{ $p->stok }}</div>
      <div class="mt-3 text-2xl font-black">Rp {{ number_format($p->harga,0,',','.') }}</div>

      <div class="mt-4 flex gap-2">
        <a href="{{ route('shop.show',$p) }}" class="rounded-2xl border px-4 py-2 hover:bg-slate-100">Detail</a>
        <form method="POST" action="{{ route('cart.add',$p) }}">
          @csrf
          <input type="hidden" name="qty" value="1">
          <button class="rounded-2xl bg-indigo-600 text-white px-4 py-2 font-semibold hover:opacity-90">
            + Keranjang
          </button>
        </form>
      </div>
    </div>
  @endforeach
</div>

<div class="mt-8">{{ $products->links() }}</div>
@endsection
