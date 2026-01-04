<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tokoku</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
  <div class="min-h-screen">
    <nav class="sticky top-0 z-30 border-b bg-white/80 backdrop-blur">
      <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <a href="{{ route('transactions.index') }}" class="font-black tracking-tight text-lg">
          🧺 Tokoku
        </a>

        <div class="flex items-center gap-2">
          @auth
            <a href="{{ route('transactions.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100">Transaksi</a>

            @if(auth()->user()->isAdmin())
              <a href="{{ route('products.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100">Produk</a>
              <a href="{{ route('customers.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100">Customer</a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="px-3 py-2 rounded-xl bg-slate-900 text-white hover:opacity-90">
                Logout
              </button>
            </form>
          @endauth
        </div>
      </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-6">
      @if(session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-900">
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-900">
          <div class="font-semibold mb-1">Terjadi kesalahan:</div>
          <ul class="list-disc ml-5">
            @foreach($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @yield('content')
    </main>
  </div>
</body>
</html>
