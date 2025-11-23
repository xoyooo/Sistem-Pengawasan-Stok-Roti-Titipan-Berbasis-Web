@extends('layouts.admin')

@section('title', 'Lokasi Toko')
@section('page_title', 'Lokasi Toko')

@section('content')
<div class="flex flex-col bg-[#fffcf0] min-h-screen overflow-hidden">
    <div class="bg-yellow-400 text-gray-900 px-6 py-3 flex items-center gap-2 shadow-sm">
        <i class="fa-solid fa-map-location-dot text-lg"></i>
        <h2 class="text-lg md:text-xl font-semibold tracking-wide">Peta Lokasi Toko Mitra</h2>
    </div>
    <div class="flex-1 relative">
        <div id="map" class="w-full h-[calc(100vh-64px)]"></div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('js/lokasi_toko.js') }}"></script>
<script>
    // Kirim data toko dari controller ke JS
    window.storeData = @json($stores);
</script>
@endsection
<style>
#map {
    border-top: 2px solid #f6e05e;
}
</style>
@endsection
