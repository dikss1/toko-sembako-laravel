@extends('layouts.admin')
@section('content')

<div class="text-2xl font-black">Dashboard</div>

<div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="text-white/70 text-sm">Total Pesanan</div>
    <div class="text-3xl font-black mt-1">{{ $totalOrders }}</div>
  </div>
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="text-white/70 text-sm">Menunggu Validasi</div>
    <div class="text-3xl font-black mt-1">{{ $waitingConfirm }}</div>
  </div>
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="text-white/70 text-sm">Produk</div>
    <div class="text-3xl font-black mt-1">{{ $products }}</div>
  </div>
</div>

@endsection
