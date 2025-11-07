<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Sales - App')</title>

    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
      /* Color & styling variables */
      .app-bg { background-color: #f3f4f6; }
      .sidebar-bg { background-color: #eef2f6; }
      .brand-green { background-color: #4CAF50; }
      .card-white { background: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
      .nav-active { background-color: #4CAF50; color: white; }
      
      /* Smooth transitions */
      .sidebar-transition { transition: transform 0.3s ease-in-out; }
      
      /* Mobile sidebar positioning */
      #mobile-sidebar.hidden { display: none; }
      #mobile-sidebar:not(.hidden) { display: block; }
    </style>
</head>
<body class="app-bg min-h-screen">

  <div class="flex flex-col h-screen">

    <!-- HEADER - Full width at top -->
    <header class="brand-green text-white px-4 md:px-8 py-6 md:py-8 flex items-center justify-between sticky top-0 z-50 shadow-lg">
      <div class="flex items-center gap-3 md:gap-4">
        <!-- Burger menu mobile -->
        <button id="burger" class="md:hidden p-2 rounded-md bg-white/10 hover:bg-white/20 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
          </svg>
        </button>

        <!-- Logo text on left -->
        <span class="text-lg md:text-2xl font-bold">Logo</span>
      </div>

      <!-- Sales text on right -->
      <span class="text-lg md:text-2xl font-semibold">Sales</span>
    </header>

    <!-- Main container with sidebar and content side by side -->
    <div class="flex flex-1 overflow-hidden">

      <!-- SIDEBAR (desktop only) -->
      <aside id="sidebar" class="sidebar-bg w-full md:w-64 p-4 md:p-6 hidden md:flex md:flex-col border-r border-gray-300 overflow-y-auto">
        <div class="mb-6 pb-4 border-b border-gray-300">
          <h2 class="text-lg md:text-xl font-bold text-gray-800">Menu</h2>
        </div>

        <nav class="space-y-1 md:space-y-2 flex-1">
          <a href="{{ route('sales.home') }}" class="flex items-center gap-3 px-3 py-2 md:py-3 rounded-lg text-sm md:text-base transition-colors {{ request()->routeIs('sales.home') ? 'nav-active' : 'text-gray-700 hover:bg-white/50' }}">
            <span class="text-lg">🏠</span>
            <span>Home</span>
          </a>

          <a href="{{ route('sales.histori') }}" class="flex items-center gap-3 px-3 py-2 md:py-3 rounded-lg text-sm md:text-base transition-colors {{ request()->routeIs('sales.histori') ? 'nav-active' : 'text-gray-700 hover:bg-white/50' }}">
            <span class="text-lg">📜</span>
            <span>Histori</span>
          </a>

          <a href="{{ route('sales.daftartoko') }}" class="flex items-center gap-3 px-3 py-2 md:py-3 rounded-lg text-sm md:text-base transition-colors {{ request()->routeIs('sales.daftartoko') ? 'nav-active' : 'text-gray-700 hover:bg-white/50' }}">
            <span class="text-lg">🏪</span>
            <span>Daftar Toko</span>
          </a>

          <a href="{{ route('sales.tambahtoko') }}" class="flex items-center gap-3 px-3 py-2 md:py-3 rounded-lg text-sm md:text-base transition-colors {{ request()->routeIs('sales.tambahtoko') ? 'nav-active' : 'text-gray-700 hover:bg-white/50' }}">
            <span class="text-lg">➕</span>
            <span>Tambah Toko</span>
          </a>

          <a href="{{ route('sales.input') }}" class="flex items-center gap-3 px-3 py-2 md:py-3 rounded-lg text-sm md:text-base transition-colors {{ request()->routeIs('sales.input') ? 'nav-active' : 'text-gray-700 hover:bg-white/50' }}">
            <span class="text-lg">✏️</span>
            <span>Input Stok</span>
          </a>

          <a href="{{ route('sales.lokasi') }}" class="flex items-center gap-3 px-3 py-2 md:py-3 rounded-lg text-sm md:text-base transition-colors {{ request()->routeIs('sales.lokasi') ? 'nav-active' : 'text-gray-700 hover:bg-white/50' }}">
            <span class="text-lg">📍</span>
            <span>Lokasi Toko</span>
          </a>
          <form action="{{ route('logout') }}" method="POST" class="p-4 border-t border-green-600">
            @csrf
            <button type="submit" 
                class="w-full bg-red-600 py-2 rounded hover:bg-red-700 transition">
                Logout
            </button>
        </form>
        </nav>
      </aside>

      <!-- MOBILE SIDEBAR (collapsible) -->
      <div id="mobile-sidebar" class="md:hidden hidden bg-white border-r border-gray-200 shadow-sm w-64 overflow-y-auto">
        <div class="p-4 border-b border-gray-300">
          <h2 class="text-lg font-bold text-gray-800">Logo</h2>
        </div>

        <nav class="space-y-1 p-3 md:p-4">
          <a href="{{ route('sales.home') }}" class="flex items-center gap-3 px-3 py-2 rounded text-sm {{ request()->routeIs('sales.home') ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
            <span class="text-lg">🏠</span>
            <span>Home</span>
          </a>

          <a href="{{ route('sales.histori') }}" class="flex items-center gap-3 px-3 py-2 rounded text-sm {{ request()->routeIs('sales.histori') ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
            <span class="text-lg">📜</span>
            <span>Histori</span>
          </a>

          <a href="{{ route('sales.daftartoko') }}" class="flex items-center gap-3 px-3 py-2 rounded text-sm {{ request()->routeIs('sales.daftartoko') ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
            <span class="text-lg">🏪</span>
            <span>Daftar Toko</span>
          </a>

          <a href="{{ route('sales.tambahtoko') }}" class="flex items-center gap-3 px-3 py-2 rounded text-sm {{ request()->routeIs('sales.tambahtoko') ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
            <span class="text-lg">➕</span>
            <span>Tambah Toko</span>
          </a>

          <a href="{{ route('sales.input') }}" class="flex items-center gap-3 px-3 py-2 rounded text-sm {{ request()->routeIs('sales.input') ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
            <span class="text-lg">✏️</span>
            <span>Input Stok</span>
          </a>
          
          <a href="{{ route('sales.lokasi') }}" class="flex items-center gap-3 px-3 py-2 rounded text-sm {{ request()->routeIs('sales.lokasi') ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
            <span class="text-lg">📍</span>
            <span>Lokasi Toko</span>
          </a>

          <form action="{{ route('logout') }}" method="POST" class="p-4 border-t border-green-600">
            @csrf
            <button type="submit" 
                class="w-full bg-red-600 py-2 rounded hover:bg-red-700 transition">
                Logout
            </button>
        </form>
        </nav>
      </div>

      <!-- CONTENT AREA -->
      <main class="flex-1 overflow-auto p-3 md:p-6">
        <div class="max-w-6xl mx-auto">
          @yield('content')
        </div>
      </main>

    </div>
  </div>

  @yield('scripts')

  <script>
    // Burger menu toggle
    document.getElementById('burger')?.addEventListener('click', function() {
      const mob = document.getElementById('mobile-sidebar');
      if (!mob) return;
      mob.classList.toggle('hidden');
    });

    // Close mobile sidebar when clicking on a link
    document.querySelectorAll('#mobile-sidebar a').forEach(link => {
      link.addEventListener('click', function() {
        document.getElementById('mobile-sidebar').classList.add('hidden');
      });
    });
  </script>
</body>
</html>
