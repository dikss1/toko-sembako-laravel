@extends('layouts.store')
@section('content')

<div class="text-2xl font-black">Checkout</div>
<div class="text-sm text-slate-500">Pilih metode pengantaran (ongkir otomatis).</div>

@php($subtotal=0)
@foreach($cart as $id=>$qty)
  @php($p = $products[$id] ?? null)
  @if(!$p) @continue @endif
  @php($qty = min($qty, (int)$p->stok))
  @php($subtotal += (int)$p->harga * (int)$qty)
@endforeach

<form method="POST" action="{{ route('checkout.place') }}" class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
  @csrf

  <div class="lg:col-span-2 rounded-3xl border bg-white p-6">
    <div class="font-bold">Ringkasan Item</div>

    <div class="mt-4 space-y-3">
      @foreach($cart as $id=>$qty)
        @php($p = $products[$id] ?? null)
        @if(!$p) @continue @endif
        @php($qty = min($qty, (int)$p->stok))
        <div class="rounded-2xl border p-4 flex items-center justify-between">
          <div>
            <div class="font-black">{{ $p->nama }}</div>
            <div class="text-xs text-slate-500">Qty: {{ $qty }} • Stok: {{ $p->stok }}</div>
          </div>
          <div class="font-bold">
            Rp {{ number_format((int)$p->harga*(int)$qty,0,',','.') }}
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-6 font-bold">Pengantaran</div>
    <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
      <label class="rounded-2xl border p-4 cursor-pointer hover:bg-slate-50">
        <input type="radio" name="shipping_method" value="pickup" class="mr-2" checked>
        <span class="font-semibold">Ambil di toko</span>
        <div class="text-xs text-slate-500 mt-1">Ongkir: Rp 0</div>
      </label>

      <label class="rounded-2xl border p-4 cursor-pointer hover:bg-slate-50">
        <input type="radio" name="shipping_method" value="delivery" class="mr-2">
        <span class="font-semibold">Diantar</span>
        <div class="text-xs text-slate-500 mt-1">Ongkir: Rp {{ number_format(config('store.shipping_fee',10000),0,',','.') }}</div>
      </label>
    </div>

    <button class="mt-6 w-full rounded-2xl bg-indigo-600 text-white px-5 py-3 font-semibold hover:opacity-90">
      Buat Order & Bayar QRIS
    </button>
  </div>

  <div class="rounded-3xl border bg-white p-6">
    <div class="text-sm text-slate-500">Subtotal</div>
    <div class="text-2xl font-black">Rp {{ number_format($subtotal,0,',','.') }}</div>

    <div class="mt-4 text-sm text-slate-500">Ongkir</div>
    <div class="font-bold">Pickup: Rp 0 • Delivery: Rp {{ number_format(config('store.shipping_fee',10000),0,',','.') }}</div>

    <div class="mt-6 rounded-2xl border bg-amber-50 p-4 text-amber-900 text-sm">
      Total final dihitung sesuai pilihan pickup/delivery saat order dibuat.
    </div>
  </div>
</form>

@endsection
