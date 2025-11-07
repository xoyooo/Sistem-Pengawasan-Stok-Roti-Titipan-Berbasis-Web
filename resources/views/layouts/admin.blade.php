<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Admin - App')</title>

    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
      .app-bg { background-color: #f3f4f6; }
      .sidebar-bg { background-color: #eef2f6; }
      .brand-green { background-color: #4CAF50; }
      .card-white { background: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
      .nav-active { background-color: #4CAF50; color: white; }
      .sidebar-transition { transition: transform 0.3s ease-in-out; }
      #mobile-sidebar.hidden { display: none; }
      #mobile-sidebar:not(.hidden) { display: block; }
    </style>
</head>
<body class="app-bg min-h-screen">

  <div class="flex flex-col h-screen">

    <!-- HEADER -->
    <header class="brand-green text-white px-4 md:px-8 py-6 md:py-8 flex items-center justify-between sticky top-0 z-50 shadow-lg">
      <div class="flex items-center gap-3 md:gap-4">
        <button id="burger" class="md:hidden p-2 rounded-md bg-white/10 hover:bg-white/20 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
          </svg>
        </button>
        <span class="text-lg md:text-2xl font-bold">Logo</span>
      </div>
      <span class="text-lg md:text-2xl font-semibold">Admin</span>
    </header>

    <!-- BODY -->
    <div class="flex flex-1 overflow-hidden">

      <!-- SIDEBAR DESKTOP -->
      <aside class="sidebar-bg w-full md:w-64 p-4 md:p-6 hidden md:flex md:flex-col border-r border-gray-300 overflow-y-auto">
        <div class="mb-6 pb-4 border-b border-gray-300">
          <h2 class="text-lg md:text-xl font-bold text-gray-800">Menu</h2>
        </div>

        <nav class="space-y-1 md:space-y-2 flex-1">
          <a href="{{ route('admin.home') }}" class="flex items-center gap-3 px-3 py-2 md:py-3 rounded-lg text-sm md:text-base transition-colors {{ request()->routeIs('admin.home') ? 'nav-active' : 'text-gray-700 hover:bg-white/50' }}">
            <span class="text-lg">🏠</span><span>Home</span>
          </a>

          <a href="{{ route('sales.histori') }}" class="flex items-center gap-3 px-3 py-2 md:py-3 rounded-lg text-sm md:text-base transition-colors {{ request()->routeIs('sales.histori') ? 'nav-active' : 'text-gray-700 hover:bg-white/50' }}">
            <span class="text-lg">📜</span>
            <span>Histori</span>
          </a>

          <a href="{{ route('admin.sales') }}" class="flex items-center gap-3 px-3 py-2 md:py-3 rounded-lg text-sm md:text-base transition-colors {{ request()->routeIs('admin.sales.*') ? 'nav-active' : 'text-gray-700 hover:bg-white/50' }}">
            <span class="text-lg">👥</span><span>Sales</span>
          </a>

          <a href="{{ route('admin.daftartoko') }}" class="flex items-center gap-3 px-3 py-2 md:py-3 rounded-lg text-sm md:text-base transition-colors {{ request()->routeIs('admin.stores') ? 'nav-active' : 'text-gray-700 hover:bg-white/50' }}">
            <span class="text-lg">🏪</span><span>Daftar Toko</span>
          </a>

          <a href="{{ route('admin.lokasitoko') }}" class="flex items-center gap-3 px-3 py-2 md:py-3 rounded-lg text-sm md:text-base transition-colors {{ request()->routeIs('admin.locations') ? 'nav-active' : 'text-gray-700 hover:bg-white/50' }}">
            <span class="text-lg">📍</span><span>Lokasi Toko</span>
          </a>

          <form action="{{ route('logout') }}" method="POST" class="pt-4 border-t border-green-600">
            @csrf
            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition">
              Logout
            </button>
          </form>
        </nav>
      </aside>

      <!-- SIDEBAR MOBILE -->
      <div id="mobile-sidebar" class="md:hidden hidden bg-white border-r border-gray-200 shadow-sm w-64 overflow-y-auto">
        <div class="p-4 border-b border-gray-300">
          <h2 class="text-lg font-bold text-gray-800">Logo</h2>
        </div>

        <nav class="space-y-1 p-3 md:p-4">
          <a href="{{ route('admin.home') }}" class="flex items-center gap-3 px-3 py-2 rounded text-sm {{ request()->routeIs('admin.home') ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
            <span class="text-lg">🏠</span><span>Home</span>
          </a>

          <a href="{{ route('sales.histori') }}" class="flex items-center gap-3 px-3 py-2 rounded text-sm {{ request()->routeIs('sales.histori') ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
            <span class="text-lg">📜</span>
            <span>Histori</span>
          </a>
          
          <a href="{{ route('admin.sales') }}" class="flex items-center gap-3 px-3 py-2 rounded text-sm {{ request()->routeIs('admin.sales.*') ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
            <span class="text-lg">👥</span><span>Sales</span>
          </a>

          <a href="{{ route('admin.daftartoko') }}" class="flex items-center gap-3 px-3 py-2 rounded text-sm {{ request()->routeIs('admin.stores') ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
            <span class="text-lg">🏪</span><span>Daftar Toko</span>
          </a>

          <a href="{{ route('admin.lokasitoko') }}" class="flex items-center gap-3 px-3 py-2 rounded text-sm {{ request()->routeIs('admin.locations') ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
            <span class="text-lg">📍</span><span>Lokasi Toko</span>
          </a>

          <form action="{{ route('logout') }}" method="POST" class="pt-4 border-t border-green-600">
            @csrf
            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition">
              Logout
            </button>
          </form>
        </nav>
      </div>

      <!-- CONTENT -->
      <main class="flex-1 overflow-auto p-3 md:p-6">
        <div class="max-w-6xl mx-auto">
          @yield('content')
        </div>
      </main>

    </div>
  </div>

  <script>
    document.getElementById('burger')?.addEventListener('click', function() {
      const mob = document.getElementById('mobile-sidebar');
      if (!mob) return;
      mob.classList.toggle('hidden');
    });
    document.querySelectorAll('#mobile-sidebar a').forEach(link => {
      link.addEventListener('click', function() {
        document.getElementById('mobile-sidebar').classList.add('hidden');
      });
    });
  </script>
</body>
</html>
