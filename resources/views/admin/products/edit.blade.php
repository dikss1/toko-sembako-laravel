@extends('layouts.admin')
@section('content')

<div class="flex items-center justify-between">
  <div>
    <div class="text-2xl font-black">Edit Produk</div>
    <div class="text-white/60 text-sm">Perbarui stok, harga, dan informasi produk.</div>
  </div>
  <a href="{{ route('admin.products.index') }}"
     class="rounded-2xl bg-white/10 px-4 py-2 font-semibold hover:bg-white/15">
    Kembali
  </a>
</div>

<div class="mt-6 rounded-3xl border border-white/10 bg-white/5 p-6">
  <form method="POST" action="{{ route('admin.products.update', $product) }}" class="space-y-5">
    @csrf
    @method('PUT')

    <div>
      <label class="text-sm text-white/70">Nama Produk</label>
      <input name="nama" value="{{ old('nama',$product->nama) }}"
             class="mt-2 w-full rounded-2xl bg-slate-950 border border-white/10 px-4 py-3 outline-none"
             required>
      @error('nama') <div class="text-rose-300 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="text-sm text-white/70">Stok</label>
        <input type="number" min="0" name="stok" value="{{ old('stok',$product->stok) }}"
               class="mt-2 w-full rounded-2xl bg-slate-950 border border-white/10 px-4 py-3 outline-none"
               required>
        @error('stok') <div class="text-rose-300 text-xs mt-1">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="text-sm text-white/70">Harga (Rp)</label>
        <input type="number" min="0" name="harga" value="{{ old('harga',$product->harga) }}"
               class="mt-2 w-full rounded-2xl bg-slate-950 border border-white/10 px-4 py-3 outline-none"
               required>
        @error('harga') <div class="text-rose-300 text-xs mt-1">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="text-sm text-white/70">Satuan (opsional)</label>
        <input name="satuan" value="{{ old('satuan',$product->satuan) }}"
               class="mt-2 w-full rounded-2xl bg-slate-950 border border-white/10 px-4 py-3 outline-none"
               placeholder="kg / pcs / dus">
        @error('satuan') <div class="text-rose-300 text-xs mt-1">{{ $message }}</div> @enderror
      </div>
    </div>

    <div>
      <label class="text-sm text-white/70">Deskripsi (opsional)</label>
      <textarea name="deskripsi" rows="4"
                class="mt-2 w-full rounded-2xl bg-slate-950 border border-white/10 px-4 py-3 outline-none"
                placeholder="Keterangan singkat produk...">{{ old('deskripsi',$product->deskripsi) }}</textarea>
      @error('deskripsi') <div class="text-rose-300 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="flex flex-col md:flex-row gap-3">
      <button class="flex-1 rounded-2xl bg-emerald-500/90 px-5 py-3 font-black hover:opacity-90">
        Simpan Perubahan
      </button>

      <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
            onsubmit="return confirm('Hapus produk ini?')" class="flex-1">
        @csrf
        @method('DELETE')
        <button type="submit" class="w-full rounded-2xl bg-rose-500/20 px-5 py-3 font-black hover:bg-rose-500/30">
          Hapus Produk
        </button>
      </form>
    </div>

  </form>
</div>

@endsection
