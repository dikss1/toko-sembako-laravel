@extends('layouts.store')
@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 rounded-3xl border bg-white p-6">
    <div class="flex items-center justify-between">
      <div>
        <div class="text-2xl font-black">Bayar via QRIS</div>
        <div class="text-slate-500 text-sm">Nominal otomatis sesuai total pesanan.</div>
      </div>
      <a href="{{ route('orders.show',$order) }}" class="rounded-2xl border px-4 py-2 hover:bg-slate-100">Detail Pesanan</a>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="rounded-3xl border p-6">
        <div class="text-sm text-slate-500">Kode Pesanan</div>
        <div class="font-black text-lg">{{ $order->kode }}</div>

        <div class="mt-4 text-sm text-slate-500">Total</div>
        <div class="text-3xl font-black">Rp {{ number_format($order->total,0,',','.') }}</div>

        <div class="mt-4 text-sm text-slate-500">Status Pembayaran</div>
        <div class="font-black">
          {{ $order->payment_status }}
        </div>

        <a target="_blank" href="{{ route('orders.invoice',$order) }}"
           class="inline-block mt-5 rounded-2xl border px-4 py-2 hover:bg-slate-100">
          Cetak Invoice / QR
        </a>
      </div>

      <div class="rounded-3xl border p-6 text-center">
        <img src="{{ asset('../assets/qris.jpg') }}" class="w-full max-w-xs mx-auto rounded-2xl border" alt="QRIS">
        <div class="mt-3 text-sm text-slate-500">Scan QRIS, lalu bayar sebesar:</div>
        <div class="text-xl font-black">Rp {{ number_format($order->total,0,',','.') }}</div>
      </div>
    </div>

    <div class="mt-6 rounded-3xl border p-6">
      <div class="font-black">Upload Bukti Pembayaran (opsional)</div>
      <div class="text-slate-500 text-sm">Jika kamu upload, admin lebih cepat validasi.</div>

      <form method="POST" action="{{ route('orders.uploadProof',$order) }}" enctype="multipart/form-data" class="mt-4 flex gap-3">
        @csrf
        <input type="file" name="proof" class="w-full rounded-2xl border px-4 py-3" accept="image/*">
        <button class="rounded-2xl bg-slate-900 text-white px-5 py-3 font-black hover:opacity-90">Upload</button>
      </form>
    </div>
  </div>

  <div class="rounded-3xl border bg-white p-6">
    <div class="text-sm text-slate-500">Ringkasan</div>
    <div class="mt-2 text-3xl font-black">Rp {{ number_format($order->total,0,',','.') }}</div>
    <div class="mt-4 text-slate-600 text-sm">
      Ongkir: Rp {{ number_format($order->shipping_fee,0,',','.') }}<br>
      Subtotal: Rp {{ number_format($order->subtotal,0,',','.') }}
    </div>
  </div>
</div>

@endsection
