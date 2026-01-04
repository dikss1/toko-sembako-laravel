@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Customer</h1>

<div class="rounded-2xl border bg-white p-6 max-w-xl">
  <form method="POST" action="{{ route('customers.update',$customer) }}" class="space-y-4">
    @csrf @method('PUT')

    <div>
      <label class="text-sm font-semibold">Nama</label>
      <input name="nama" value="{{ old('nama',$customer->nama) }}" class="w-full rounded-xl border px-3 py-2" required>
      @error('nama') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div class="flex gap-2">
      <button class="rounded-xl bg-indigo-600 text-white px-4 py-2 font-semibold hover:opacity-90">Update</button>
      <a href="{{ route('customers.index') }}" class="rounded-xl border px-4 py-2 hover:bg-slate-50">Batal</a>
    </div>
  </form>
</div>
@endsection
