@extends('layouts.store')
@section('content')

<div class="text-2xl font-black">Checkout</div>
<div class="text-slate-500 text-sm">Pilih pengiriman. Ongkir 10rb jika diantar.</div>

<div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 rounded-3xl border bg-white p-6">
    <div class="font-black">Ringkasan Item</div>
    <div class="mt-4 space-y-3">
      @foreach($items as $it)
        <div class="flex items-center justify-between border-b pb-3">
          <div>
            <div class="font-semibold">{{ $it['p']->nama }}</div>
            <div class="text-sm text-slate-500">Qty: {{ $it['qty'] }}</div>
          </div>
          <div class="font-black">Rp {{ number_format($it['line'],0,',','.') }}</div>
        </div>
      @endforeach
    </div>
  </div>

  <div class="rounded-3xl border bg-white p-6">
    <div class="font-black">Pengiriman</div>

    <form method="POST" action="{{ route('orders.place') }}" class="mt-4 space-y-4">
      @csrf

      <div class="rounded-2xl border p-4">
        <label class="flex items-center gap-2">
          <input type="radio" name="delivery_method" value="pickup" checked>
          <span class="font-semibold">Ambil di Toko (Gratis)</span>
        </label>
        <label class="flex items-center gap-2 mt-3">
          <input type="radio" name="delivery_method" value="delivery">
          <span class="font-semibold">Diantar (Ongkir Rp 10.000)</span>
        </label>
      </div>

      <div class="rounded-2xl bg-slate-50 border p-4 text-slate-700">
        <div class="text-sm text-slate-500">Subtotal</div>
        <div class="text-xl font-black">Rp {{ number_format($subtotal,0,',','.') }}</div>
      </div>

      <button class="w-full rounded-2xl bg-indigo-600 text-white px-5 py-3 font-black hover:opacity-90">
        Buat Pesanan & Bayar QRIS
      </button>
    </form>
  </div>
</div>

@endsection
