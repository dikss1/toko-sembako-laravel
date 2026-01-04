@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 bg-white border rounded-2xl p-6 shadow-sm">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-black">Checkout</h1>
        <p class="text-slate-500 text-sm">Tambah item, qty otomatis dibatasi stok.</p>
      </div>
      <a href="{{ route('transactions.index') }}" class="px-4 py-2 rounded-xl border hover:bg-slate-50">Kembali</a>
    </div>

    <form method="POST" action="{{ route('transactions.store') }}" class="mt-6 space-y-6" id="trxForm">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="text-sm font-semibold">Nama</label>
          <input class="mt-1 w-full rounded-xl border px-4 py-2 bg-slate-50"
                 value="{{ $customer->nama }}" readonly>
        </div>
        <div>
          <label class="text-sm font-semibold">Tanggal</label>
          <input type="date" name="tanggal" value="{{ date('Y-m-d') }}"
                 class="mt-1 w-full rounded-xl border px-4 py-2">
        </div>
      </div>

      {{-- data products untuk javascript (AMAN, tanpa map function panjang) --}}
      <script id="products-json" type="application/json">
        {!! $products->map(fn($p)=>[
            'id'=>$p->id,
            'nama'=>$p->nama,
            'harga'=>(int)$p->harga,
            'stok'=>(int)$p->stok
        ])->values()->toJson() !!}
      </script>

      <div class="rounded-2xl border bg-slate-50 p-4">
        <div class="flex items-center justify-between">
          <div class="font-semibold">Item</div>
          <button type="button" id="addRow"
                  class="rounded-xl bg-slate-900 text-white px-4 py-2 text-sm hover:opacity-90">
            + Tambah Item
          </button>
        </div>

        <div id="warnBox" class="hidden mt-3 rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-amber-900 text-sm"></div>

        <div class="mt-4 overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="text-left text-slate-600">
              <tr>
                <th class="py-2 pr-2">Produk</th>
                <th class="py-2 pr-2 w-28">Qty</th>
                <th class="py-2 pr-2 w-36">Harga</th>
                <th class="py-2 pr-2 w-36">Subtotal</th>
                <th class="py-2 w-24">Aksi</th>
              </tr>
            </thead>
            <tbody id="itemsBody"></tbody>
          </table>
        </div>
      </div>

      <div class="flex items-center justify-end">
        <button class="rounded-xl bg-indigo-600 text-white px-5 py-3 font-semibold hover:opacity-90">
          Buat Pesanan
        </button>
      </div>
    </form>
  </div>

  <div class="bg-white border rounded-2xl p-6 shadow-sm">
    <div class="text-sm text-slate-500">Total</div>
    <div class="mt-2 text-3xl font-black" id="grandTotal">Rp 0</div>

    <div class="mt-6 rounded-2xl border bg-emerald-50 p-4 text-emerald-900">
      <div class="font-semibold">Info</div>
      <div class="text-sm mt-1">
        Jika qty melebihi stok, qty akan otomatis disesuaikan.
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const products = JSON.parse(document.getElementById('products-json').textContent || '[]');

  const tbody = document.getElementById('itemsBody');
  const btnAdd = document.getElementById('addRow');
  const grandTotalEl = document.getElementById('grandTotal');
  const warnBox = document.getElementById('warnBox');

  let rowIndex = 0;

  const rupiah = (n) => 'Rp ' + (Number(n||0)).toString().replace(/\B(?=(\d{3})+(?!\d))/g,'.');

  function showWarn(msg){
    warnBox.textContent = msg;
    warnBox.classList.remove('hidden');
    setTimeout(()=> warnBox.classList.add('hidden'), 2500);
  }

  function makeOptions(){
    return products.map(p => `<option value="${p.id}" data-harga="${p.harga}" data-stok="${p.stok}">
      ${p.nama} (stok: ${p.stok})
    </option>`).join('');
  }

  function recalc(){
    let total = 0;
    tbody.querySelectorAll('tr').forEach(tr => {
      const sel = tr.querySelector('.productSel');
      const qty = tr.querySelector('.qtyInp');
      const opt = sel.options[sel.selectedIndex];
      const h = parseInt(opt.dataset.harga || '0', 10);
      const q = parseInt(qty.value || '0', 10);
      total += h*q;
    });
    grandTotalEl.textContent = rupiah(total);
  }

  function bindRow(tr){
    const sel = tr.querySelector('.productSel');
    const qty = tr.querySelector('.qtyInp');
    const harga = tr.querySelector('.hargaInp');
    const sub = tr.querySelector('.subInp');
    const del = tr.querySelector('.delBtn');

    function syncMaxAndTotal(){
      const opt = sel.options[sel.selectedIndex];
      const stok = parseInt(opt.dataset.stok || '0', 10);
      const h = parseInt(opt.dataset.harga || '0', 10);

      qty.max = stok; // <= ini yang kamu minta
      let q = parseInt(qty.value || '1', 10);

      if (stok <= 0) {
        qty.value = 0;
        showWarn(`Stok ${opt.textContent.trim()} habis.`);
        q = 0;
      } else if (q > stok) {
        qty.value = stok;
        showWarn(`Maksimal untuk produk ini: ${stok}. Qty disesuaikan.`);
        q = stok;
      } else if (q < 1) {
        qty.value = 1;
        q = 1;
      }

      harga.value = rupiah(h);
      sub.value = rupiah(h*q);
      recalc();
    }

    sel.addEventListener('change', syncMaxAndTotal);
    qty.addEventListener('input', syncMaxAndTotal);

    del.addEventListener('click', () => {
      tr.remove();
      recalc();
    });

    syncMaxAndTotal();
  }

  function addRow(){
    const tr = document.createElement('tr');
    tr.className = "border-t border-slate-200";
    tr.innerHTML = `
      <td class="py-2 pr-2">
        <select name="items[${rowIndex}][product_id]" class="w-full rounded-xl border px-3 py-2 productSel">
          ${makeOptions()}
        </select>
      </td>
      <td class="py-2 pr-2">
        <input type="number" min="1" value="1" name="items[${rowIndex}][qty]"
               class="w-full rounded-xl border px-3 py-2 qtyInp" />
      </td>
      <td class="py-2 pr-2">
        <input type="text" class="w-full rounded-xl border px-3 py-2 hargaInp bg-slate-50" value="0" readonly />
      </td>
      <td class="py-2 pr-2">
        <input type="text" class="w-full rounded-xl border px-3 py-2 subInp bg-slate-50" value="0" readonly />
      </td>
      <td class="py-2">
        <button type="button" class="rounded-xl border px-3 py-2 hover:bg-slate-100 delBtn">Hapus</button>
      </td>
    `;
    tbody.appendChild(tr);
    rowIndex++;
    bindRow(tr);
  }

  btnAdd.addEventListener('click', addRow);
  addRow(); // default 1 row
});
</script>
@endpush
@endsection
