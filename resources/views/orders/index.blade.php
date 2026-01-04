@extends('layouts.store')
@section('content')

<div class="flex items-center justify-between">
  <div>
    <div class="text-2xl font-black">Pesanan Saya</div>
    <div class="text-slate-500 text-sm">Lihat status: diproses / dikirim / selesai.</div>
  </div>
  <a href="{{ route('shop.index') }}" class="rounded-2xl border px-4 py-2 hover:bg-slate-100">Belanja Lagi</a>
</div>

<div class="mt-6 rounded-3xl border bg-white p-6">
  @if($orders->count()===0)
    <div class="text-center text-slate-500 py-10">Belum ada pesanan.</div>
  @else
    <div class="space-y-4">
      @foreach($orders as $o)
        <a href="{{ route('orders.show',$o) }}" class="block rounded-2xl border p-4 hover:bg-slate-50">
          <div class="flex items-center justify-between">
            <div>
              <div class="font-black">{{ $o->kode }}</div>
              <div class="text-sm text-slate-500">
                {{ $o->tanggal->format('d M Y') }} • {{ $o->delivery_method === 'delivery' ? 'Diantar' : 'Ambil' }}
              </div>
            </div>
            <div class="text-right">
              <div class="font-black">Rp {{ number_format($o->total,0,',','.') }}</div>
              <div class="text-sm text-slate-500">Status: {{ $o->status }} • {{ $o->payment_status }}</div>
            </div>
          </div>
        </a>
      @endforeach
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
  @endif
</div>

@endsection
