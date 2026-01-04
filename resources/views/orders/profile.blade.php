@extends('layouts.store')
@section('content')

<div class="rounded-3xl bg-gradient-to-r from-orange-500 to-rose-500 p-8 text-white">
  <div class="text-2xl font-black">{{ $customer?->nama ?? auth()->user()->name }}</div>
  <div class="text-white/80 text-sm">Profil & menu cepat</div>
</div>

<div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 rounded-3xl border bg-white p-6">
    <div class="font-black text-lg">Menu</div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
      <a href="{{ route('orders.index') }}" class="rounded-3xl border p-5 hover:bg-slate-50">
        <div class="font-black">Pesanan Saya</div>
        <div class="text-sm text-slate-500">Lihat status: diproses/dikirim/selesai</div>
      </a>

      <a href="{{ route('cart.index') }}" class="rounded-3xl border p-5 hover:bg-slate-50">
        <div class="font-black">Keranjang</div>
        <div class="text-sm text-slate-500">Checkout lebih cepat</div>
      </a>
    </div>
  </div>

  <div class="rounded-3xl border bg-white p-6">
    <div class="font-black">Alamat</div>
    <div class="text-sm text-slate-500 mt-1">
      {{ $customer?->alamat ?? '-' }}<br>
      {{ $customer?->no_tlp ?? '-' }}
    </div>
  </div>
</div>

@endsection
