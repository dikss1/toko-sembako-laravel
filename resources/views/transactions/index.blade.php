@extends('layouts.app')
@section('content')

<div class="flex items-center justify-between mb-4">
    <div>
        <h1 class="text-2xl font-black">Transaksi</h1>
        <p class="text-slate-500 text-sm">Kelola transaksi kamu.</p>
    </div>
    <a href="{{ route('transactions.create') }}" class="px-4 py-2 rounded-xl bg-indigo-600 text-white font-semibold hover:opacity-90">
        + Buat Transaksi
    </a>
</div>

<div class="bg-white border rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr>
                <th class="p-3">Kode</th>
                <th class="p-3">Tanggal</th>
                <th class="p-3">Customer</th>
                <th class="p-3">Total</th>
                <th class="p-3 w-40">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
            <tr class="border-t">
                <td class="p-3 font-semibold">{{ $t->kode }}</td>
                <td class="p-3">{{ $t->tanggal }}</td>
                <td class="p-3">{{ $t->customer->nama ?? '-' }}</td>
                <td class="p-3 font-bold">Rp {{ number_format($t->grand_total,0,',','.') }}</td>
                <td class="p-3 flex gap-2">
                    <a href="{{ route('transactions.show',$t->id) }}" class="px-3 py-2 rounded-xl border hover:bg-slate-50">Detail</a>

                    <form action="{{ route('transactions.destroy',$t->id) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus transaksi ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-2 rounded-xl border hover:bg-rose-50">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $transactions->links() }}</div>
@endsection
