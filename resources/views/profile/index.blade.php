@extends('layouts.store')
@section('content')

<div class="rounded-3xl border bg-white p-6">
  <div class="flex items-center justify-between">
    <div>
      <div class="text-2xl font-black">Profil</div>
      <div class="text-sm text-slate-500">Ringkasan akun & pesanan.</div>
    </div>
    <a href="{{ route('orders.index') }}" class="rounded-2xl border px-4 py-2 hover:bg-slate-100">Pesanan</a>
  </div>

  <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="rounded-2xl border bg-slate-50 p-4">
      <div class="text-sm text-slate-500">Nama</div>
      <div class="font-bold">{{ auth()->user()->name }}</div>
    </div>
    <div class="rounded-2xl border bg-slate-50 p-4">
      <div class="text-sm text-slate-500">Email</div>
      <div class="font-bold">{{ auth()->user()->email }}</div>
    </div>
    <div class="rounded-2xl border bg-slate-50 p-4">
      <div class="text-sm text-slate-500">Role</div>
      <div class="font-bold">{{ auth()->user()->role }}</div>
    </div>
  </div>

  <div class="mt-8 font-bold">Pesanan Terakhir</div>
  <div class="mt-3 space-y-3">
    @forelse($orders as $o)
      <div class="rounded-2xl border p-4 flex items-center justify-between">
        <div>
          <div class="font-black">{{ $o->kode }}</div>
          <div class="text-xs text-slate-500">{{ $o->tanggal }}</div>
        </div>
        <a class="rounded-xl border px-3 py-2 hover:bg-slate-100" href="{{ route('orders.pay',$o->id) }}">
          Lihat / Bayar
        </a>
      </div>
    @empty
      <div class="text-sm text-slate-500">Belum ada pesanan.</div>
    @endforelse
  </div>
</div>

@endsection
