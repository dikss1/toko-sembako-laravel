@extends('layouts.app')
@section('content')

<div class="bg-white border rounded-2xl p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black">{{ $transaction->kode }}</h1>
            <p class="text-slate-500 text-sm">{{ $transaction->tanggal }} • {{ $transaction->customer->nama }}</p>
        </div>
        <a href="{{ route('transactions.index') }}" class="px-4 py-2 rounded-xl border hover:bg-slate-50">Kembali</a>
    </div>

    <div class="mt-6 border rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="p-3">Produk</th>
                    <th class="p-3 w-24">Qty</th>
                    <th class="p-3 w-32">Harga</th>
                    <th class="p-3 w-32">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->items as $it)
                <tr class="border-t">
                    <td class="p-3">{{ $it->product->nama ?? '-' }}</td>
                    <td class="p-3">{{ $it->qty }}</td>
                    <td class="p-3">Rp {{ number_format($it->harga,0,',','.') }}</td>
                    <td class="p-3 font-semibold">Rp {{ number_format($it->subtotal,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 text-right text-xl font-black">
        Total: Rp {{ number_format($transaction->grand_total,0,',','.') }}
    </div>
</div>

@endsection
