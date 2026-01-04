<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin • TokoSembako.id</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100">
  <div class="border-b border-white/10 bg-slate-950/80 backdrop-blur">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
      <div class="font-black text-lg">Admin Panel</div>

      <div class="flex items-center gap-3">
        <a href="{{ route('admin.dashboard') }}" class="text-white/80 hover:text-white">Dashboard</a>
        <a href="{{ route('admin.products.index') }}" class="text-white/80 hover:text-white">Produk</a>
        <a href="{{ route('admin.orders.index') }}" class="text-white/80 hover:text-white">Pesanan</a>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="rounded-2xl bg-white/10 px-4 py-2 font-semibold hover:bg-white/15">Logout</button>
        </form>
      </div>
    </div>
  </div>

  <main class="max-w-6xl mx-auto px-4 py-8">
    @if(session('success'))
      <div class="mb-4 rounded-2xl bg-emerald-500/10 border border-emerald-400/20 p-4 text-emerald-200">{{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="mb-4 rounded-2xl bg-rose-500/10 border border-rose-400/20 p-4 text-rose-200">
        {{ $errors->first('msg') ?? $errors->first() }}
      </div>
    @endif

    @yield('content')
  </main>
</body>
</html>
