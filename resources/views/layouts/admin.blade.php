<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Admin - App')</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        crossorigin="anonymous" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
</head>

<body class="min-h-screen bg-gray-100">

    <!-- ======================= -->
    <!-- HEADER MOBILE (FIXED) -->
    <!-- ======================= -->
    <header class="md:hidden w-full bg-yellow-400 px-4 py-3 flex justify-between items-center shadow z-30">
        <!-- Left -->
        <div class="flex items-center gap-3">
            <button id="burger"
                class="p-2 bg-yellow-300 rounded-lg shadow active:scale-95 transition">
                <i class="fa-solid fa-bars text-gray-800 text-lg"></i>
            </button>

            <div>
                <h1 class="font-bold text-base text-gray-900">Toko Roti Akbar</h1>
                <p class="text-xs uppercase text-gray-700 tracking-wider">ADMIN</p>
            </div>
        </div>

        <!-- Right -->
        <div class="p-2 bg-yellow-300 rounded-full shadow">
            <i class="fa-solid fa-user text-gray-800"></i>
        </div>
    </header>


    <!-- WRAPPER -->
    <div class="flex flex-col h-screen">

        <!-- ======================= -->
        <!-- SIDEBAR DESKTOP -->
        <!-- ======================= -->
        <aside id="sidebar" class="sidebar-bg z-20">
            <div class="sidebar-header text-center py-5 border-b border-yellow-300 shadow-sm bg-yellow-400">
                <h1 class="font-bold text-lg text-gray-900">Toko Roti Akbar</h1>
                <p class="text-xs tracking-widest text-gray-800">ADMIN</p>
            </div>

            <nav class="flex-1 mt-3">

                <a href="{{ route('admin.home') }}"
                   class="nav-link {{ request()->routeIs('admin.home') ? 'nav-active' : '' }}">
                  <i class="fa-solid fa-house"></i> <span>Home</span>
                </a>

                <a href="{{ route('admin.histori') }}"
                   class="nav-link {{ request()->routeIs('admin.histori') ? 'nav-active' : '' }}">
                  <i class="fa-solid fa-clock-rotate-left"></i> <span>Histori</span>
                </a>

                <a href="{{ route('admin.sales') }}"
                   class="nav-link {{ request()->routeIs('admin.sales*') ? 'nav-active' : '' }}">
                  <i class="fa-solid fa-users"></i> <span>Sales</span>
                </a>

                <a href="{{ route('admin.target') }}"
                    class="nav-link {{ request()->routeIs('admin.target') ? 'nav-active' : '' }}">
                    <i class="fa-solid fa-bullseye"></i> <span>Target</span>
                </a>

                <a href="{{ route('admin.statistik') }}"
                   class="nav-link {{ request()->routeIs('admin.statistik') ? 'nav-active' : '' }}">
                  <i class="fa-solid fa-chart-column"></i> <span>Statistik</span>
                </a>

                <a href="{{ route('admin.daftartoko') }}"
                   class="nav-link {{ request()->routeIs('admin.daftartoko') ? 'nav-active' : '' }}">
                  <i class="fa-solid fa-store"></i> <span>Daftar Toko</span>
                </a>

                <a href="{{ route('admin.lokasitoko') }}"
                   class="nav-link {{ request()->routeIs('admin.lokasitoko') ? 'nav-active' : '' }}">
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


        <!-- ======================= -->
        <!-- SIDEBAR MOBILE -->
        <!-- ======================= -->
        <div id="mobile-sidebar" class="z-30">
            <div class="panel">
                <div class="flex justify-between items-center p-4 bg-yellow-300 border-b border-yellow-400">
                    <h2 class="font-bold text-gray-800 text-lg">Menu</h2>
                    <button id="closeSidebar" class="text-gray-800 text-xl">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <nav class="p-3 flex-1">

                    <a href="{{ route('admin.home') }}"
                       class="nav-link {{ request()->routeIs('admin.home') ? 'nav-active' : '' }}">
                        <i class="fa-solid fa-house"></i> Home
                    </a>

                    <a href="{{ route('admin.histori') }}"
                       class="nav-link {{ request()->routeIs('admin.histori') ? 'nav-active' : '' }}">
                        <i class="fa-solid fa-clock-rotate-left"></i> Histori
                    </a>

                    <a href="{{ route('admin.sales') }}"
                       class="nav-link {{ request()->routeIs('admin.sales*') ? 'nav-active' : '' }}">
                        <i class="fa-solid fa-users"></i> Sales
                    </a>
                    
                    <a href="{{ route('admin.target') }}" class="nav-link {{ request()->routeIs('admin.target') ? 'nav-active' : '' }}">
                        <i class="fa-solid fa-bullseye"></i> Target
                    </a>

                    <a href="{{ route('admin.statistik') }}"
                       class="nav-link {{ request()->routeIs('admin.statistik') ? 'nav-active' : '' }}">
                        <i class="fa-solid fa-chart-column"></i> Statistik
                    </a>

                    <a href="{{ route('admin.daftartoko') }}"
                       class="nav-link {{ request()->routeIs('admin.daftartoko') ? 'nav-active' : '' }}">
                        <i class="fa-solid fa-store"></i> Daftar Toko
                    </a>

                    <a href="{{ route('admin.lokasitoko') }}"
                       class="nav-link {{ request()->routeIs('admin.lokasitoko') ? 'nav-active' : '' }}">
                        <i class="fa-solid fa-location-dot"></i> Lokasi Toko
                    </a>


                    <div class="mt-4 border-t border-yellow-300 pt-3">
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

        <!-- ======================= -->
        <!-- CONTENT -->
        <!-- ======================= -->
        <main class="flex-1 overflow-auto p-3 md:p-6 pt-20 md:pt-6">
            <div class="max-w-6xl mx-auto">
                @yield('content')
            </div>
        </main>

    </div>

    @yield('scripts')
    <script src="{{ asset('js/layout.js') }}"></script>

</body>
</html>
