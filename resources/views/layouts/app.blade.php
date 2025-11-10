<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Sales - App')</title>

    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
</head>

<body class="min-h-screen">

  <!-- HEADER MOBILE -->
  <header class="md:hidden">
    <div class="flex items-center gap-2">
      <button id="burger" class="p-2 bg-white/40 rounded-md hover:bg-white/60 transition">
        <i class="fa-solid fa-bars text-gray-800"></i>
      </button>
      <div>
        <h1 class="font-bold text-base">Toko Roti Akbar</h1>
        <p class="text-xs uppercase tracking-widest">Sales</p>
      </div>
    </div>
    <div class="bg-yellow-100 p-2 rounded-full">
      <i class="fa-solid fa-user text-gray-700"></i>
    </div>
  </header>

  <div class="flex flex-col h-screen">

    <!-- SIDEBAR DESKTOP -->
    <aside id="sidebar" class="sidebar-bg">
      <div class="sidebar-header text-center py-5 border-b border-yellow-300 shadow-sm">
        <h1 class="font-bold text-lg text-gray-900">Toko Roti Akbar</h1>
        <p class="text-xs tracking-widest text-gray-700">SALES</p>
      </div>

      <nav class="flex-1 mt-3">
        <a href="{{ route('sales.home') }}" class="nav-link {{ request()->routeIs('sales.home') ? 'nav-active' : '' }}">
          <i class="fa-solid fa-house"></i> <span>Beranda</span>
        </a>
        <a href="{{ route('sales.histori') }}" class="nav-link {{ request()->routeIs('sales.histori') ? 'nav-active' : '' }}">
          <i class="fa-solid fa-clock-rotate-left"></i> <span>Histori</span>
        </a>
        <a href="{{ route('sales.daftartoko') }}" class="nav-link {{ request()->routeIs('sales.daftartoko') ? 'nav-active' : '' }}">
          <i class="fa-solid fa-store"></i> <span>Daftar Toko</span>
        </a>
        <a href="{{ route('sales.tambahtoko') }}" class="nav-link {{ request()->routeIs('sales.tambahtoko') ? 'nav-active' : '' }}">
          <i class="fa-solid fa-plus"></i> <span>Tambah Toko</span>
        </a>
        <a href="{{ route('sales.input') }}" class="nav-link {{ request()->routeIs('sales.input') ? 'nav-active' : '' }}">
          <i class="fa-solid fa-pen-to-square"></i> <span>Input Stok</span>
        </a>
        <a href="{{ route('sales.lokasi') }}" class="nav-link {{ request()->routeIs('sales.lokasi') ? 'nav-active' : '' }}">
          <i class="fa-solid fa-location-dot"></i> <span>Lokasi Toko</span>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto mb-4 text-center">
          @csrf
          <button type="submit" class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
          </button>
        </form>
      </nav>
    </aside>

    <!-- SIDEBAR MOBILE -->
    <div id="mobile-sidebar">
      <div class="panel">
        <div class="flex justify-between items-center p-4 border-b border-yellow-300 bg-yellow-50">
          <h2 class="font-bold text-gray-800 text-lg">Menu</h2>
          <button id="closeSidebar" class="text-gray-700 text-xl">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>

        <nav class="p-3 flex-1">
          <a href="{{ route('sales.home') }}" class="nav-link {{ request()->routeIs('sales.home') ? 'nav-active' : '' }}">
            <i class="fa-solid fa-house"></i> Beranda
          </a>
          <a href="{{ route('sales.histori') }}" class="nav-link {{ request()->routeIs('sales.histori') ? 'nav-active' : '' }}">
            <i class="fa-solid fa-clock-rotate-left"></i> Histori
          </a>
          <a href="{{ route('sales.daftartoko') }}" class="nav-link {{ request()->routeIs('sales.daftartoko') ? 'nav-active' : '' }}">
            <i class="fa-solid fa-store"></i> Daftar Toko
          </a>
          <a href="{{ route('sales.tambahtoko') }}" class="nav-link {{ request()->routeIs('sales.tambahtoko') ? 'nav-active' : '' }}">
            <i class="fa-solid fa-plus"></i> Tambah Toko
          </a>
          <a href="{{ route('sales.input') }}" class="nav-link {{ request()->routeIs('sales.input') ? 'nav-active' : '' }}">
            <i class="fa-solid fa-pen-to-square"></i> Input Stok
          </a>
          <a href="{{ route('sales.lokasi') }}" class="nav-link {{ request()->routeIs('sales.lokasi') ? 'nav-active' : '' }}">
            <i class="fa-solid fa-location-dot"></i> Lokasi Toko
          </a>

          <div class="mt-4 border-t border-yellow-200 pt-3">
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
              </button>
            </form>
          </div>
        </nav>
      </div>
    </div>

    <!-- CONTENT -->
    <main class="flex-1 overflow-auto p-3 md:p-6">
      <div class="max-w-6xl mx-auto">
        @yield('content')
      </div>
    </main>
  </div>


@yield('scripts')

  <!-- Custom JS -->
  <script src="{{ asset('js/layout.js') }}"></script>

</body>
</html>
