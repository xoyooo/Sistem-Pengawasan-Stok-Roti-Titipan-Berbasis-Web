@extends('layouts.app')

@section('title', 'Sales - Input Stok Harian')

@section('content')
    <div class="flex flex-col min-h-screen bg-white border-4 border-[#fde047] rounded-md px-6 md:px-12 py-8">

        <!-- Header -->
        <div class="bg-[#fffcf0] text-gray-900 px-6 py-3 rounded-t-xl shadow-sm flex items-center gap-2 mb-6">
            <i class="fa-solid fa-bread-slice text-lg"></i>
            <h2 class="text-lg md:text-xl font-semibold tracking-wide">Input Stok Harian</h2>
        </div>
        <form action="{{ route('sales.stok.store') }}" method="POST" enctype="multipart/form-data"
            class="animate-fade-in space-y-8">
            @csrf
            <div>
                <label for="nama_toko" class="block text-gray-700 font-semibold mb-2">Nama Toko</label>
                <select name="nama_toko" id="nama_toko"
                    class="w-full px-4 py-2 border-2 border-yellow-400 rounded-lg bg-[#fffcee] focus:ring-2 focus:ring-yellow-500 focus:outline-none transition"
                    required>
                    <option value="">Pilih Toko</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->name }}">{{ $store->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="jumlah_roti" class="block text-gray-700 font-semibold mb-2">Jumlah Roti</label>
                <input type="number" name="jumlah_roti" id="jumlah_roti"
                    class="w-full px-4 py-2 border-2 border-yellow-400 rounded-lg bg-[#fffcee] focus:ring-2 focus:ring-yellow-500 focus:outline-none transition"
                    placeholder="Masukkan jumlah roti" required>
            </div>
            <div>
                <label for="jumlah_sisa" class="block text-gray-700 font-semibold mb-2">Jumlah Sisa</label>
                <input type="number" name="jumlah_sisa" id="jumlah_sisa"
                    class="w-full px-4 py-2 border-2 border-yellow-400 rounded-lg bg-[#fffcee] focus:ring-2 focus:ring-yellow-500 focus:outline-none transition"
                    placeholder="Masukkan jumlah sisa roti" required>
            </div>
            <div>
                <label for="tanggal_pengantaran" class="block text-gray-700 font-semibold mb-2">Tanggal Pengantaran</label>
                <input type="date" name="tanggal_pengantaran" id="tanggal_pengantaran"
                    class="w-full px-4 py-2 border-2 border-yellow-400 rounded-lg bg-[#fffcee] focus:ring-2 focus:ring-yellow-500 focus:outline-none transition"
                    required>
            </div>
            <div>
                <label for="foto_roti" class="block text-gray-700 font-semibold mb-2">Foto Roti</label>
                <label for="foto_roti" id="uploadRotiArea"
                    class="border-2 border-dashed border-yellow-400 rounded-lg p-8 text-center bg-yellow-50 hover:bg-yellow-100 cursor-pointer transition block">
                    <div class="flex flex-col items-center justify-center transition-all duration-300">
                        <i class="fa-solid fa-cloud-arrow-up text-yellow-500 text-4xl mb-2 animate-bounce"></i>
                        <p class="text-gray-700 mb-1 font-medium">Klik atau seret foto roti ke sini</p>
                        <p class="text-gray-400 text-sm">Maksimum size: 2 MB</p>
                    </div>
                </label>
                <input type="file" name="foto_roti" id="foto_roti" class="hidden" accept="image/*">
                <div id="file-name" class="text-sm text-gray-600 mt-2"></div>
            </div>
            <div>
                <label for="foto_sisa" class="block text-gray-700 font-semibold mb-2">Foto Jumlah Sisa</label>
                <label for="foto_sisa" id="uploadSisaArea"
                    class="border-2 border-dashed border-yellow-400 rounded-lg p-8 text-center bg-yellow-50 hover:bg-yellow-100 cursor-pointer transition block">
                    <div class="flex flex-col items-center justify-center transition-all duration-300">
                        <i class="fa-solid fa-cloud-arrow-up text-yellow-500 text-4xl mb-2 animate-bounce"></i>
                        <p class="text-gray-700 mb-1 font-medium">Klik atau seret foto sisa roti ke sini</p>
                        <p class="text-gray-400 text-sm">Maksimum size: 2 MB</p>
                    </div>
                </label>
                <input type="file" name="foto_sisa" id="foto_sisa" class="hidden" accept="image/*">
                <div id="file-name-sisa" class="text-sm text-gray-600 mt-2"></div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-yellow-200">
                <button type="submit"
                    class="w-full sm:w-auto bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-2 px-8 rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-save mr-1"></i> Simpan
                </button>
                <a href="{{ route('sales.home') }}"
                    class="w-full sm:w-auto text-center border-2 border-yellow-400 text-yellow-600 hover:bg-yellow-50 font-bold py-2 px-8 rounded-lg transition transform hover:-translate-y-0.5 hover:shadow-sm">
                    <i class="fa-solid fa-xmark mr-1"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <script src="https://kit.fontawesome.com/a2e0e6adf0.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/input_stok.js') }}"></script>


    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
    </style>
@endsection