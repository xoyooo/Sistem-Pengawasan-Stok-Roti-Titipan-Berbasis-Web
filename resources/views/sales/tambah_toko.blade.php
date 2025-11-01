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
                <input type="text" name="phone" class="w-full px-4 py-2 border-2 border-green-500 rounded-lg focus:ring-2 focus:ring-green-600" placeholder="Masukkan nomor HP" required>
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
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Tanggal Bergabung</label>
            <input type="date" name="join_date" class="w-full px-4 py-2 border-2 border-green-500 rounded-lg focus:ring-2 focus:ring-green-600" required>
        </div>

        <!-- Foto Upload (Multiple) -->
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

            <!-- Preview Container -->
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

<!-- SCRIPT -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const uploadArea = document.getElementById('upload-area');
const fileInput = document.getElementById('photo');
const uploadContent = document.getElementById('upload-content');
const previewContainer = document.getElementById('preview-container');

let selectedFiles = []; // simpan semua file yang dipilih

uploadArea.addEventListener('click', () => fileInput.click());
uploadArea.addEventListener('dragover', e => {
    e.preventDefault();
    uploadArea.classList.add('bg-green-100');
});
uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('bg-green-100'));
uploadArea.addEventListener('drop', e => {
    e.preventDefault();
    uploadArea.classList.remove('bg-green-100');
    handleFiles(e.dataTransfer.files);
});
fileInput.addEventListener('change', () => handleFiles(fileInput.files));

function handleFiles(files) {
    Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
            selectedFiles.push(file);
        }
    });
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
                <button type="button" data-index="${index}" 
                    class="btn-hapus absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">&times;</button>
            `;
            previewContainer.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });

    uploadContent.innerHTML = `<p class="text-green-600 font-semibold">${selectedFiles.length} foto dipilih</p>`;
}

// tombol hapus
previewContainer.addEventListener('click', e => {
    if (e.target.classList.contains('btn-hapus')) {
        const index = e.target.getAttribute('data-index');
        selectedFiles.splice(index, 1);
        showPreviews();
    }
});

// ============ AJAX Submit ==============
$('#formTambahToko').on('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    selectedFiles.forEach(file => formData.append('photo[]', file));

    $.ajax({
        url: "{{ route('sales.store') }}", // pastikan route-nya benar
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            Swal.fire({
                title: 'Menyimpan data...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data toko dan foto berhasil disimpan!',
                timer: 2000,
                showConfirmButton: false
            });
            $('#formTambahToko')[0].reset();
            previewContainer.innerHTML = '';
            selectedFiles = [];
            uploadContent.innerHTML = `
                <svg class="w-12 h-12 text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <p class="text-gray-600 mb-1">Drag and drop atau klik untuk upload</p>
                <p class="text-gray-400 text-sm">Maksimum size: 5 MB per foto</p>`;
        },
        error: function(xhr) {
            let msg = xhr.responseJSON?.message || 'Terjadi kesalahan. Coba lagi!';
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: msg
            });
        }
    });
});
</script>

@endsection
