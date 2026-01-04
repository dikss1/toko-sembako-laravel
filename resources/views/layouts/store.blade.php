<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TokoSembako.id</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
  <div class="bg-gradient-to-r from-indigo-700 via-fuchsia-600 to-rose-500">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
      <a href="{{ route('shop.index') }}" class="text-white font-black text-xl">TokoSembako<span class="opacity-80">.id</span></a>

      <div class="flex items-center gap-3">
        <a href="{{ route('cart.index') }}" class="text-white/90 hover:text-white font-semibold">Keranjang</a>

        @auth
          @if(auth()->user()->role === 'customer')
            <a href="{{ route('profile') }}" class="text-white/90 hover:text-white font-semibold">Profil</a>
            <a href="{{ route('orders.index') }}" class="text-white/90 hover:text-white font-semibold">Pesanan Saya</a>
          @endif

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="rounded-2xl bg-white/15 px-4 py-2 text-white font-semibold hover:bg-white/25">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="rounded-2xl bg-white/15 px-4 py-2 text-white font-semibold hover:bg-white/25">Login</a>
          <a href="{{ route('register') }}" class="rounded-2xl bg-white text-slate-900 px-4 py-2 font-black">Register</a>
        @endauth
      </div>
    </div>
  </div>

  <main class="max-w-6xl mx-auto px-4 py-8">
    @if(session('success'))
      <div class="mb-4 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-900">{{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="mb-4 rounded-2xl bg-rose-50 border border-rose-200 p-4 text-rose-900">
        {{ $errors->first('msg') ?? $errors->first() }}
      </div>
    @endif

    @yield('content')
  </main>

  <footer class="py-10 text-center text-sm text-slate-500">
    © {{ date('Y') }} TokoSembako.id — Belanja mudah, cepat, aman.
  </footer>
</body>
</html>
