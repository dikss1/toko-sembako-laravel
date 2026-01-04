@extends('layouts.admin')
@section('content')

<div class="flex items-center justify-between">
  <div>
    <div class="text-2xl font-black">Detail Pesanan</div>
    <div class="text-white/60 text-sm">{{ $order->kode }} • {{ $order->customer->nama }}</div>
  </div>
  <a href="{{ route('admin.orders.index') }}" class="rounded-2xl bg-white/10 px-4 py-2 hover:bg-white/15">Kembali</a>
</div>

<div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="font-black">Item</div>
    <div class="mt-4 space-y-3">
      @foreach($order->items as $it)
        <div class="flex items-center justify-between border-b border-white/10 pb-3">
          <div>
            <div class="font-semibold">{{ $it->product->nama }}</div>
            <div class="text-sm text-white/60">Qty: {{ $it->qty }}</div>
          </div>
          <div class="font-black">Rp {{ number_format($it->subtotal,0,',','.') }}</div>
        </div>
      @endforeach
    </div>

    <div class="mt-6 text-right">
      <div class="text-sm text-white/60">Subtotal: Rp {{ number_format($order->subtotal,0,',','.') }}</div>
      <div class="text-sm text-white/60">Ongkir: Rp {{ number_format($order->shipping_fee,0,',','.') }}</div>
      <div class="text-2xl font-black">Total: Rp {{ number_format($order->total,0,',','.') }}</div>
    </div>
  </div>

  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="font-black">Aksi Admin</div>

    <div class="mt-4 text-sm text-white/60">
      Pembayaran: <span class="text-white font-semibold">{{ $order->payment_status }}</span><br>
      Status: <span class="text-white font-semibold">{{ $order->status }}</span>
    </div>

    @if($order->payment_proof_path)
      <div class="mt-4">
        <div class="text-sm text-white/60 mb-2">Bukti:</div>
        <a target="_blank" href="{{ asset('storage/'.$order->payment_proof_path) }}" class="underline">Lihat Bukti</a>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.orders.paid',$order) }}" class="mt-5">
      @csrf
      <button class="w-full rounded-2xl bg-emerald-500/90 px-4 py-3 font-black hover:opacity-90">
        Validasi Pembayaran (Set Paid)
      </button>
    </form>

    <form method="POST" action="{{ route('admin.orders.status',$order) }}" class="mt-4">
      @csrf
      <label class="text-sm text-white/60">Ubah Status</label>
      <select name="status" class="mt-2 w-full rounded-2xl bg-slate-950 border border-white/10 px-4 py-3">
        <option value="menunggu_pembayaran">menunggu_pembayaran</option>
        <option value="diproses">diproses</option>
        <option value="dikirim">dikirim</option>
        <option value="selesai">selesai</option>
        <option value="dibatalkan">dibatalkan</option>
      </select>
      <button class="w-full mt-3 rounded-2xl bg-white/10 px-4 py-3 font-black hover:bg-white/15">
        Simpan Status
      </button>
    </form>
  </div>
</div>

@endsection
