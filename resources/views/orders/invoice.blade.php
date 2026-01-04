<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Invoice {{ $order->kode }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white p-8">
  <div class="max-w-2xl mx-auto border rounded-2xl p-6">
    <div class="flex items-center justify-between">
      <div>
        <div class="text-2xl font-black">Invoice</div>
        <div class="text-slate-500 text-sm">{{ $order->kode }}</div>
      </div>
      <button onclick="window.print()" class="rounded-xl border px-4 py-2">Print</button>
    </div>

    <div class="mt-6 grid grid-cols-2 gap-6">
      <div>
        <div class="font-black">Total Bayar</div>
        <div class="text-3xl font-black mt-1">Rp {{ number_format($order->total,0,',','.') }}</div>

        <div class="mt-4 text-sm text-slate-600">
          Ongkir: Rp {{ number_format($order->shipping_fee,0,',','.') }}<br>
          Subtotal: Rp {{ number_format($order->subtotal,0,',','.') }}
        </div>
      </div>

      <div class="text-center">
        <img src="{{ asset('images/qris.jpg') }}" class="w-full rounded-2xl border" alt="QRIS">
        <div class="mt-2 text-sm text-slate-500">Scan QRIS dan bayar sesuai total.</div>
      </div>
    </div>

    <div class="mt-6">
      <div class="font-black">Item</div>
      <div class="mt-2 space-y-2 text-sm">
        @foreach($order->items as $it)
          <div class="flex justify-between">
            <div>{{ $it->product->nama }} (x{{ $it->qty }})</div>
            <div class="font-semibold">Rp {{ number_format($it->subtotal,0,',','.') }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</body>
</html>
