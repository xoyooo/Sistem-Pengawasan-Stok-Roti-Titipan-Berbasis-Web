@extends('layouts.app')

@section('title', 'Sales - Tambah Toko')
@section('page-title', 'Tambah Toko Mitra')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg p-6">
    <h1 class="text-3xl font-bold text-green-600 mb-8">Tambah Toko Mitra</h1>
    
    <form id="formTambahToko" enctype="multipart/form-data">
        @csrf

        <!-- Row 1 -->
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Toko</label>
                <input type="text" name="name" class="w-full px-4 py-2 border-2 border-green-500 rounded-lg focus:ring-2 focus:ring-green-600" placeholder="Masukkan nama toko" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">No HP / WhatsApp</label>
                <input type="number" name="phone" class="w-full px-4 py-2 border-2 border-green-500 rounded-lg focus:ring-2 focus:ring-green-600" placeholder="Masukkan nomor HP" required>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Pemilik</label>
                <input type="text" name="owner_name" class="w-full px-4 py-2 border-2 border-green-500 rounded-lg focus:ring-2 focus:ring-green-600" placeholder="Masukkan nama pemilik" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Alamat Lengkap</label>
                <input type="text" name="address" class="w-full px-4 py-2 border-2 border-green-500 rounded-lg focus:ring-2 focus:ring-green-600" placeholder="Masukkan alamat lengkap" required>
            </div>
        </div>

        <!-- Row 3 -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Tanggal Bergabung -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Tanggal Bergabung</label>
                <input type="date" name="join_date"
                    class="w-full px-4 py-2 border-2 border-green-500 rounded-lg focus:ring-2 focus:ring-green-600 focus:outline-none" required>
            </div>

            <!-- Lokasi Toko -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Lokasi Toko</label>
                <div class="flex flex-wrap md:flex-nowrap items-center gap-2">
                    <button type="button" id="btnMap"
                        class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 transition w-full md:w-auto">
                        Pilih dari Peta
                    </button>
                    <input type="text" name="latitude" id="latitude" placeholder="Lat"
                        class="w-full md:w-24 px-3 py-2 border-2 border-green-400 rounded-lg text-sm focus:ring-1 focus:ring-green-500 focus:outline-none"
                        readonly>
                    <input type="text" name="longitude" id="longitude" placeholder="Lng"
                        class="w-full md:w-24 px-3 py-2 border-2 border-green-400 rounded-lg text-sm focus:ring-1 focus:ring-green-500 focus:outline-none"
                        readonly>
                </div>
            </div>
        </div>



        <!-- Foto Upload -->
        <div class="mb-8">
            <label class="block text-gray-700 font-semibold mb-2">Foto Toko</label>
            <div id="upload-area" class="border-2 border-dashed border-green-500 rounded-lg p-8 text-center bg-gray-50 hover:bg-gray-100 cursor-pointer transition">
                <input type="file" id="photo" name="photo[]" multiple class="hidden" accept="image/*">
                <div id="upload-content" class="flex flex-col items-center justify-center">
                    <svg class="w-12 h-12 text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <p class="text-gray-600 mb-1">Drag and drop atau klik untuk upload</p>
                    <p class="text-gray-400 text-sm">Maksimum size: 5 MB per foto</p>
                </div>
            </div>
            <div id="preview-container" class="grid grid-cols-3 gap-4 mt-4"></div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition">
                Simpan
            </button>
            <button type="reset" class="border-2 border-green-500 text-green-500 hover:bg-green-50 font-bold py-2 px-6 rounded-lg transition">
                Hapus
            </button>
        </div>
    </form>
</div>

<!-- Modal Peta -->
<div id="mapModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-4 shadow-xl w-11/12 md:w-2/3 lg:w-1/2 relative">
        <button id="closeMap" class="absolute top-2 right-3 text-gray-500 hover:text-gray-800 text-xl">&times;</button>
        <h2 class="text-lg font-bold mb-3 text-green-600">Pilih Lokasi Toko</h2>
        <div id="map" style="height: 400px;" class="rounded-lg border border-green-300"></div>
        <div class="flex justify-end mt-4">
            <button id="saveMap" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Simpan Lokasi</button>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<!-- SCRIPT -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<script>
let selectedFiles = [];
const uploadArea = document.getElementById('upload-area');
const fileInput = document.getElementById('photo');
const uploadContent = document.getElementById('upload-content');
const previewContainer = document.getElementById('preview-container');

// ==== Upload Foto ====
uploadArea.addEventListener('click', () => fileInput.click());
uploadArea.addEventListener('dragover', e => { e.preventDefault(); uploadArea.classList.add('bg-green-100'); });
uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('bg-green-100'));
uploadArea.addEventListener('drop', e => { e.preventDefault(); uploadArea.classList.remove('bg-green-100'); handleFiles(e.dataTransfer.files); });
fileInput.addEventListener('change', () => handleFiles(fileInput.files));

function handleFiles(files) {
    Array.from(files).forEach(file => { if (file.type.startsWith('image/')) selectedFiles.push(file); });
    showPreviews();
}
function showPreviews() {
    previewContainer.innerHTML = '';
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = e => {
            const wrapper = document.createElement('div');
            wrapper.className = "relative inline-block m-2";
            wrapper.innerHTML = `
                <img src="${e.target.result}" class="h-32 w-32 object-cover rounded-lg shadow border" />
                <button type="button" data-index="${index}" class="btn-hapus absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">&times;</button>`;
            previewContainer.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
    uploadContent.innerHTML = `<p class="text-green-600 font-semibold">${selectedFiles.length} foto dipilih</p>`;
}
previewContainer.addEventListener('click', e => {
    if (e.target.classList.contains('btn-hapus')) {
        const index = e.target.getAttribute('data-index');
        selectedFiles.splice(index, 1);
        showPreviews();
    }
});

// ==== MAP POPUP (Leaflet) ====
const mapModal = document.getElementById('mapModal');
const btnMap = document.getElementById('btnMap');
const closeMap = document.getElementById('closeMap');
const saveMap = document.getElementById('saveMap');
let map, marker, selectedLatLng;

btnMap.addEventListener('click', () => {
    mapModal.classList.remove('hidden');
    if (!map) {
        map = L.map('map').setView([3.5952, 98.6722], 13); // Medan default
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(map);
        map.on('click', function(e) {
            selectedLatLng = e.latlng;
            if (marker) marker.setLatLng(e.latlng);
            else marker = L.marker(e.latlng).addTo(map);
        });
    } else {
        setTimeout(() => map.invalidateSize(), 200);
    }
});
closeMap.addEventListener('click', () => mapModal.classList.add('hidden'));
saveMap.addEventListener('click', () => {
    if (selectedLatLng) {
        document.getElementById('latitude').value = selectedLatLng.lat.toFixed(6);
        document.getElementById('longitude').value = selectedLatLng.lng.toFixed(6);
        Swal.fire({ icon: 'success', title: 'Lokasi berhasil dipilih!', timer: 1500, showConfirmButton: false });
    }
    mapModal.classList.add('hidden');
});

// ==== SUBMIT AJAX ====
$('#formTambahToko').on('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    selectedFiles.forEach(file => formData.append('photo[]', file));

    $.ajax({
        url: "{{ route('sales.store') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            Swal.fire({ title: 'Menyimpan data...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        },
        success: function() {
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Data toko dan foto berhasil disimpan!', timer: 2000, showConfirmButton: false });
            $('#formTambahToko')[0].reset();
            previewContainer.innerHTML = '';
            selectedFiles = [];
        },
        error: function(xhr) {
            let msg = xhr.responseJSON?.message || 'Terjadi kesalahan. Coba lagi!';
            Swal.fire({ icon: 'error', title: 'Gagal!', text: msg });
        }
    });
});
</script>
@endsection