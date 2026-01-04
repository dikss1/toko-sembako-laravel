@extends('layouts.app')
@section('content')

<div class="flex items-center justify-between mb-4">
  <div>
    <h1 class="text-2xl font-bold">Master Customer</h1>
    <p class="text-slate-500 text-sm">Kelola data customer.</p>
  </div>
  <a href="{{ route('customers.create') }}" class="rounded-xl bg-indigo-600 text-white px-4 py-2 font-semibold hover:opacity-90">+ Tambah</a>
</div>

<div class="rounded-2xl border bg-white overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-slate-50 text-slate-600">
      <tr>
        <th class="text-left px-4 py-3">Nama</th>
        <th class="text-left px-4 py-3 w-40">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($customers as $c)
      <tr class="border-t">
        <td class="px-4 py-3 font-semibold">{{ $c->nama }}</td>
        <td class="px-4 py-3 flex gap-2">
          <a class="px-3 py-1 rounded-lg border hover:bg-slate-50" href="{{ route('customers.edit',$c) }}">Edit</a>
          <form method="POST" action="{{ route('customers.destroy',$c) }}" onsubmit="return confirm('Hapus customer?')">
            @csrf @method('DELETE')
            <button class="px-3 py-1 rounded-lg border hover:bg-slate-50">Hapus</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-4">{{ $customers->links() }}</div>
@endsection
