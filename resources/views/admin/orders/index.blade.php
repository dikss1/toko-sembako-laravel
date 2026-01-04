@extends('layouts.admin')
@section('content')

<div class="text-2xl font-black">Pesanan</div>
<div class="text-white/60 text-sm">Kelola pembayaran & status pengiriman.</div>

<div class="mt-6 rounded-3xl border border-white/10 bg-white/5 p-4">
  @foreach($orders as $o)
    <a href="{{ route('admin.orders.show',$o) }}" class="block rounded-2xl border border-white/10 p-4 hover:bg-white/5 mb-3">
      <div class="flex items-center justify-between">
        <div>
          <div class="font-black">{{ $o->kode }}</div>
          <div class="text-sm text-white/60">{{ $o->customer->nama }} • {{ $o->delivery_method }}</div>
        </div>
        <div class="text-right">
          <div class="font-black">Rp {{ number_format($o->total,0,',','.') }}</div>
          <div class="text-sm text-white/60">{{ $o->status }} • {{ $o->payment_status }}</div>
        </div>
      </div>
    </a>
  @endforeach

  <div class="mt-4">{{ $orders->links() }}</div>
</div>

@endsection
