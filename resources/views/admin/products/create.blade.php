@extends('layouts.admin')
@section('content')

<div class="flex items-center justify-between">
  <div>
    <div class="text-2xl font-black">Tambah Produk</div>
    <div class="text-white/60 text-sm">Masukkan data produk baru.</div>
  </div>
  <a href="{{ route('admin.products.index') }}"
     class="rounded-2xl bg-white/10 px-4 py-2 font-semibold hover:bg-white/15">
    Kembali
  </a>
</div>

<div class="mt-6 rounded-3xl border border-white/10 bg-white/5 p-6">
  <form method="POST" action="{{ route('admin.products.store') }}" class="space-y-5">
    @csrf

    <div>
      <label class="text-sm text-white/70">Nama Produk</label>
      <input name="nama" value="{{ old('nama') }}"
             class="mt-2 w-full rounded-2xl bg-slate-950 border border-white/10 px-4 py-3 outline-none"
             placeholder="Contoh: Beras 5kg" required>
      @error('nama') <div class="text-rose-300 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="text-sm text-white/70">Stok</label>
        <input type="number" min="0" name="stok" value="{{ old('stok',0) }}"
               class="mt-2 w-full rounded-2xl bg-slate-950 border border-white/10 px-4 py-3 outline-none"
               required>
        @error('stok') <div class="text-rose-300 text-xs mt-1">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="text-sm text-white/70">Harga (Rp)</label>
        <input type="number" min="0" name="harga" value="{{ old('harga',0) }}"
               class="mt-2 w-full rounded-2xl bg-slate-950 border border-white/10 px-4 py-3 outline-none"
               required>
        @error('harga') <div class="text-rose-300 text-xs mt-1">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="text-sm text-white/70">Satuan (opsional)</label>
        <input name="satuan" value="{{ old('satuan') }}"
               class="mt-2 w-full rounded-2xl bg-slate-950 border border-white/10 px-4 py-3 outline-none"
               placeholder="kg / pcs / dus">
        @error('satuan') <div class="text-rose-300 text-xs mt-1">{{ $message }}</div> @enderror
      </div>
    </div>

    <div>
      <label class="text-sm text-white/70">Deskripsi (opsional)</label>
      <textarea name="deskripsi" rows="4"
                class="mt-2 w-full rounded-2xl bg-slate-950 border border-white/10 px-4 py-3 outline-none"
                placeholder="Keterangan singkat produk...">{{ old('deskripsi') }}</textarea>
      @error('deskripsi') <div class="text-rose-300 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <button class="w-full rounded-2xl bg-emerald-500/90 px-5 py-3 font-black hover:opacity-90">
      Simpan Produk
    </button>
  </form>
</div>

@endsection
