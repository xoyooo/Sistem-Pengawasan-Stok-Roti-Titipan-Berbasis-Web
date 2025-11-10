@extends('layouts.app')

@section('title', 'Sales - Home')
@section('page_title', 'Home')

@section('content')
    <div class="p-6 space-y-8">

        <!-- Tombol Aksi Lebar Penuh -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Kartu Input Stok Roti -->
            <a href="{{ route('sales.input') }}"
                class="group bg-yellow-50 border border-yellow-100 rounded-2xl shadow-md p-8 flex flex-col items-center text-center transition-all hover:shadow-lg hover:-translate-y-1">
                <div class="bg-yellow-400 w-14 h-14 flex items-center justify-center rounded-lg mb-4">
                    <i class="fa-solid fa-box text-white text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1 text-lg">Input Stok Roti</h3>
                <p class="text-gray-600 text-sm">Kelola dan catat stok roti yang tersedia untuk dijual</p>
            </a>

            <!-- Kartu Lihat Lokasi Toko -->
            <a href="{{ route('sales.lokasi') }}"
                class="group bg-yellow-50 border border-yellow-100 rounded-2xl shadow-md p-8 flex flex-col items-center text-center transition-all hover:shadow-lg hover:-translate-y-1">
                <div class="bg-yellow-400 w-14 h-14 flex items-center justify-center rounded-lg mb-4">
                    <i class="fa-solid fa-location-dot text-white text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1 text-lg">Lihat Lokasi Toko</h3>
                <p class="text-gray-600 text-sm">Temukan dan lihat daftar lokasi toko mitra</p>
            </a>
        </div>

        <!-- Peta Lokasi -->
        <div>
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Peta Lokasi Toko Mitra</h2>
            <div id="map" class="w-full h-[500px] rounded-2xl shadow-md"></div>
        </div>
    </div>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi peta di sekitar Medan
            var map = L.map('map').setView([3.5952, 98.6722], 12);

            // Tambahkan layer OSM
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Ambil data toko dari controller
            var stores = @json($stores ?? []);

            // Tambahkan marker untuk setiap toko
            stores.forEach(function (store) {
                if (store.latitude && store.longitude) {
                    L.marker([store.latitude, store.longitude])
                        .addTo(map)
                        .bindPopup("<b>" + store.name + "</b><br>" + store.address);
                }
            });
        });
    </script>
@endsection