@extends('layouts.store')
@section('content')

<div class="flex items-center justify-between">
  <div>
    <div class="text-2xl font-black">Detail Pesanan</div>
    <div class="text-slate-500 text-sm">{{ $order->kode }} • Status: {{ $order->status }} • Bayar: {{ $order->payment_status }}</div>
  </div>
  <div class="flex gap-2">
    <a href="{{ route('orders.pay',$order) }}" class="rounded-2xl bg-indigo-600 text-white px-4 py-2 font-black hover:opacity-90">Bayar QRIS</a>
    <a href="{{ route('orders.index') }}" class="rounded-2xl border px-4 py-2 hover:bg-slate-100">Kembali</a>
  </div>
</div>

<div class="mt-6 rounded-3xl border bg-white p-6">
  <div class="font-black">Item</div>
  <div class="mt-4 space-y-3">
    @foreach($order->items as $it)
      <div class="flex items-center justify-between border-b pb-3">
        <div>
          <div class="font-semibold">{{ $it->product->nama }}</div>
          <div class="text-sm text-slate-500">Qty: {{ $it->qty }}</div>
        </div>
        <div class="font-black">Rp {{ number_format($it->subtotal,0,',','.') }}</div>
      </div>
    @endforeach
  </div>

  <div class="mt-6 text-right">
    <div class="text-sm text-slate-500">Subtotal: Rp {{ number_format($order->subtotal,0,',','.') }}</div>
    <div class="text-sm text-slate-500">Ongkir: Rp {{ number_format($order->shipping_fee,0,',','.') }}</div>
    <div class="text-2xl font-black">Total: Rp {{ number_format($order->total,0,',','.') }}</div>
  </div>
</div>

@endsection
