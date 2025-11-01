@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen bg-gray-100">
    {{-- Main content --}}
    <div class="w-full max-w-4xl mx-auto p-4 md:p-8">
        <div class="bg-white rounded-lg shadow">
            {{-- Card Header --}}
            <div class="bg-green-500 text-white px-4 md:px-8 py-3 md:py-4 rounded-t-lg">
                <h2 class="text-lg md:text-2xl font-semibold">Inputan Harian</h2>
            </div>

            {{-- Card Body --}}
            <div class="p-4 md:p-8">
                <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Grid layout untuk desktop: 2 kolom untuk fields yang bisa dipasangkan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Toko --}}
                        <div>
                            <label for="nama_toko" class="block text-sm font-medium text-gray-700 mb-2">Nama Toko</label>
                            <select name="nama_toko" id="nama_toko" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                <option value="">Pilih Toko</option>
                                <option value="Toko 1">Toko 1</option>
                                <option value="Toko 2">Toko 2</option>
                                <option value="Toko 3">Toko 3</option>
                            </select>
                        </div>

                        {{-- Jumlah Roti --}}
                        <div>
                            <label for="jumlah_roti" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Roti</label>
                            <input type="number" name="jumlah_roti" id="jumlah_roti" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Masukkan jumlah roti" required>
                        </div>
                    </div>

                    {{-- Tanggal Pengantaran (full width) --}}
                    <div>
                        <label for="tanggal_pengantaran" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengantaran</label>
                        <input type="date" name="tanggal_pengantaran" id="tanggal_pengantaran" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    </div>

                    {{-- Foto Roti (full width) --}}
                    <div>
                        <label for="foto_roti" class="block text-sm font-medium text-gray-700 mb-2">Foto Roti</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-md p-8 text-center hover:border-green-500 transition">
                            <input type="file" name="foto_roti" id="foto_roti" class="hidden" accept="image/*">
                            <label for="foto_roti" class="cursor-pointer">
                                <div class="text-gray-500 mb-2">
                                    <svg class="w-10 h-10 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium">Klik untuk upload atau drag file</p>
                                <p class="text-xs text-gray-400 mt-1">Maksimum size: 2 MB</p>
                            </label>
                        </div>
                        <div id="file-name" class="text-sm text-gray-600 mt-2"></div>
                    </div>

                    {{-- Buttons dengan spacing yang lebih baik di desktop --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button type="submit" class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-8 rounded-md transition">
                            Simpan
                        </button>
                        <a href="{{ route('sales.home') }}" class="w-full sm:w-auto text-center border-2 border-green-500 text-green-500 hover:bg-green-50 font-medium py-2 px-8 rounded-md transition">
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
