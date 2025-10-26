@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row gap-4 md:gap-0 min-h-screen bg-gray-100">
    {{-- Main content --}}
    <div class="w-full md:w-3/4 p-4 md:p-6">
        <div class="bg-white rounded-lg shadow">
            {{-- Card Header --}}
            <div class="bg-green-500 text-white px-4 md:px-6 py-3 md:py-4 rounded-t-lg">
                <h2 class="text-lg md:text-xl font-semibold">Inputan Harian</h2>
            </div>

            {{-- Card Body --}}
            <div class="p-4 md:p-6">
                <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-5">
                    @csrf

                    {{-- Nama Toko --}}
                    <div>
                        <label for="nama_toko" class="block text-sm font-medium text-gray-700 mb-2">Nama Toko</label>
                        <select name="nama_toko" id="nama_toko" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                            <option value="">Pilih Toko</option>
                            <option value="Toko 1">Toko 1</option>
                            <option value="Toko 2">Toko 2</option>
                            <option value="Toko 3">Toko 3</option>
                        </select>
                    </div>

                    {{-- Jumlah Roti --}}
                    <div>
                        <label for="jumlah_roti" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Roti</label>
                        <input type="number" name="jumlah_roti" id="jumlah_roti" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Masukkan jumlah roti" required>
                    </div>

                    {{-- Tanggal Pengantaran --}}
                    <div>
                        <label for="tanggal_pengantaran" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengantaran</label>
                        <input type="date" name="tanggal_pengantaran" id="tanggal_pengantaran" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    </div>

                    {{-- Foto Roti --}}
                    <div>
                        <label for="foto_roti" class="block text-sm font-medium text-gray-700 mb-2">Foto Roti</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-md p-6 text-center hover:border-green-500 transition">
                            <input type="file" name="foto_roti" id="foto_roti" class="hidden" accept="image/*">
                            <label for="foto_roti" class="cursor-pointer">
                                <div class="text-gray-500 mb-2">
                                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <p class="text-sm">Klik untuk upload atau drag file</p>
                                <p class="text-xs text-gray-400 mt-1">Maksimum size: 2 MB</p>
                            </label>
                        </div>
                        <div id="file-name" class="text-sm text-gray-600 mt-2"></div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <button type="submit" class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-6 rounded-md transition">
                            Simpan
                        </button>
                        <a href="{{ route('sales.home') }}" class="w-full sm:w-auto text-center border-2 border-green-500 text-green-500 hover:bg-green-50 font-medium py-2 px-6 rounded-md transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle file upload display
    document.getElementById('foto_roti').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || '';
        document.getElementById('file-name').textContent = fileName ? 'File: ' + fileName : '';
    });
</script>
@endsection
