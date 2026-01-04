@extends('layouts.store')
@section('content')

<div class="flex items-center justify-between">
  <div>
    <div class="text-2xl font-black">Keranjang</div>
    <div class="text-slate-500 text-sm">Periksa qty, otomatis maksimal sesuai stok.</div>
  </div>
  <a href="{{ route('shop.index') }}" class="rounded-2xl border px-4 py-2 hover:bg-slate-100">Belanja Lagi</a>
</div>

<div class="mt-6 rounded-3xl border bg-white p-6">
  @if(count($items)===0)
    <div class="text-center text-slate-500 py-10">Keranjang kosong.</div>
  @else
    <div class="space-y-4">
      @foreach($items as $it)
        <div class="flex items-center justify-between gap-4 border-b pb-4">
          <div>
            <div class="font-black">{{ $it['p']->nama }}</div>
            <div class="text-sm text-slate-500">Harga: Rp {{ number_format($it['p']->harga,0,',','.') }} • Stok: {{ $it['p']->stok }}</div>
          </div>

          <div class="flex items-center gap-2">
            <form method="POST" action="{{ route('cart.update',$it['p']) }}" class="flex items-center gap-2">
              @csrf
              <input type="number" name="qty" min="1" max="{{ $it['p']->stok }}" value="{{ $it['qty'] }}"
                     class="w-24 rounded-2xl border px-3 py-2" />
              <button class="rounded-2xl border px-3 py-2 hover:bg-slate-100">Update</button>
            </form>

            <form method="POST" action="{{ route('cart.remove',$it['p']) }}">
              @csrf
              <button class="rounded-2xl border px-3 py-2 hover:bg-rose-50">Hapus</button>
            </form>
          </div>

          <div class="font-black">Rp {{ number_format($it['line'],0,',','.') }}</div>
        </div>
      @endforeach
    </div>

    <div class="mt-6 flex items-center justify-between">
      <form method="POST" action="{{ route('cart.clear') }}">
        @csrf
        <button class="rounded-2xl border px-4 py-2 hover:bg-slate-100">Kosongkan</button>
      </form>

      <div class="text-right">
        <div class="text-sm text-slate-500">Subtotal</div>
        <div class="text-2xl font-black">Rp {{ number_format($subtotal,0,',','.') }}</div>
        <a href="{{ route('orders.checkout') }}" class="inline-block mt-3 rounded-2xl bg-indigo-600 text-white px-6 py-3 font-black hover:opacity-90">
          Checkout
        </a>
      </div>
    </div>
  @endif
</div>

@endsection
