@extends('layouts.admin')
@section('content')

<div class="flex items-center justify-between">
  <div>
    <div class="text-2xl font-black">Produk</div>
    <div class="text-white/60 text-sm">Kelola katalog toko (stok & harga).</div>
  </div>
  <a href="{{ route('admin.products.create') }}"
     class="rounded-2xl bg-white/10 px-5 py-3 font-black hover:bg-white/15">
    + Tambah Produk
  </a>
</div>

<div class="mt-6 rounded-3xl border border-white/10 bg-white/5 p-4 overflow-x-auto">
  <table class="w-full text-sm">
    <thead class="text-left text-white/60">
      <tr>
        <th class="py-3 pr-3">Nama</th>
        <th class="py-3 pr-3">Stok</th>
        <th class="py-3 pr-3">Harga</th>
        <th class="py-3 pr-3">Satuan</th>
        <th class="py-3 pr-3 w-40">Aksi</th>
      </tr>
    </thead>
    <tbody class="align-top">
      @forelse($products as $p)
        <tr class="border-t border-white/10">
          <td class="py-3 pr-3">
            <div class="font-black">{{ $p->nama }}</div>
            @if($p->deskripsi)
              <div class="text-white/60 text-xs mt-1 line-clamp-2">{{ $p->deskripsi }}</div>
            @endif
          </td>
          <td class="py-3 pr-3 font-semibold">{{ $p->stok }}</td>
          <td class="py-3 pr-3 font-black">Rp {{ number_format($p->harga,0,',','.') }}</td>
          <td class="py-3 pr-3 text-white/70">{{ $p->satuan ?? '-' }}</td>
          <td class="py-3 pr-3">
            <div class="flex gap-2">
              <a href="{{ route('admin.products.edit', $p) }}"
                 class="rounded-xl bg-white/10 px-3 py-2 font-semibold hover:bg-white/15">
                Edit
              </a>

              <form method="POST" action="{{ route('admin.products.destroy', $p) }}"
                    onsubmit="return confirm('Hapus produk ini?')">
                @csrf
                @method('DELETE')
                <button class="rounded-xl bg-rose-500/20 px-3 py-2 font-semibold hover:bg-rose-500/30">
                  Hapus
                </button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="py-10 text-center text-white/60">Belum ada produk.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-4">{{ $products->links() }}</div>
</div>

@endsection
