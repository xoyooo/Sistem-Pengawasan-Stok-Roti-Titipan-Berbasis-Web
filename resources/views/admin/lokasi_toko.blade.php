@extends('layouts.admin')

@section('title', 'Lokasi Toko')
@section('page_title', 'Lokasi Toko')

@section('content')
<div class="p-4">
    <h2 class="text-2xl font-semibold mb-4">Peta Lokasi Toko</h2>

    <div id="map" style="height: 500px; border-radius: 10px;"></div>
</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi peta di Medan
    var map = L.map('map').setView([3.5952, 98.6722], 12);

    // Tambahkan layer OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Ambil data toko dari Laravel
    var stores = @json($stores);

    // Tambahkan marker untuk setiap toko
    stores.forEach(function(store) {
        if (store.latitude && store.longitude) {
            var marker = L.marker([store.latitude, store.longitude]).addTo(map);
            marker.bindPopup(
                "<b>" + store.name + "</b><br>" + store.address
            );
        }
    });
});
</script>
@endsection
