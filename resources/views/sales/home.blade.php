@extends('layouts.app')

@section('title', 'Sales - Home')
@section('page_title', 'Home')

@section('content')
<div class="p-6 space-y-8">

    <!-- 📌 Total Pendapatan -->
    <div class="bg-white border border-yellow-200 rounded-2xl shadow-md p-6 text-center">
        <h3 class="text-gray-700 font-semibold text-lg mb-2">
            Total Uang Terkumpul
        </h3>

        <p class="text-3xl font-bold text-green-600 tracking-wide">
            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        </p>

        <p class="text-gray-500 text-sm mt-1">
            Dari seluruh penjualan yang sudah tercatat
        </p>
    </div>

    <!-- Tombol Aksi Lebar Penuh -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Kartu Input Stok Roti -->
        <a href="{{ route('sales.input') }}" 
           class="group bg-yellow-50 border border-yellow-100 rounded-2xl shadow-md p-8 flex flex-col items-center text-center transition-all hover:shadow-lg hover:-translate-y-1">
            <div class="bg-yellow-400 w-14 h-14 flex items-center justify-center rounded-lg mb-4">
                <i class="fa-solid fa-box text-white text-2xl"></i>
            </div>
            <h3 class="font-semibold text-gray-800 mb-1 text-lg">Input Stok Roti</h3>
            <p class="text-gray-600 text-sm">Catat stok masuk sebelum pengantaran</p>
        </a>

        <!-- Kartu Input Sisa Roti -->
        <a href="{{ route('sales.sisa.create') }}" 
           class="group bg-yellow-50 border border-yellow-100 rounded-2xl shadow-md p-8 flex flex-col items-center text-center transition-all hover:shadow-lg hover:-translate-y-1">
            <div class="bg-yellow-400 w-14 h-14 flex items-center justify-center rounded-lg mb-4">
                <i class="fa-solid fa-clipboard-check text-white text-2xl"></i>
            </div>
            <h3 class="font-semibold text-gray-800 mb-1 text-lg">Input Sisa Roti</h3>
            <p class="text-gray-600 text-sm">Catat sisa roti setelah pengambilan</p>
        </a>

        <!-- Kartu Lokasi Toko -->
        <a href="{{ route('sales.lokasi') }}" 
           class="group bg-yellow-50 border border-yellow-100 rounded-2xl shadow-md p-8 flex flex-col items-center text-center transition-all hover:shadow-lg hover:-translate-y-1">
            <div class="bg-yellow-400 w-14 h-14 flex items-center justify-center rounded-lg mb-4">
                <i class="fa-solid fa-location-dot text-white text-2xl"></i>
            </div>
            <h3 class="font-semibold text-gray-800 mb-1 text-lg">Lihat Lokasi Toko</h3>
            <p class="text-gray-600 text-sm">Temukan dan lihat daftar lokasi toko mitra</p>
        </a>

    </div>
    <!-- 🧾 Tabel Hasil Penjualan -->
    <div class="bg-white border border-yellow-200 rounded-2xl shadow-md p-6 mt-10">
        <h3 class="text-gray-700 font-semibold text-lg mb-4">
            Riwayat Penjualan Terkumpul
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-yellow-100 text-gray-700 font-semibold">
                    <tr>
                        <th class="px-4 py-2 border">Tanggal</th>
                        <th class="px-4 py-2 border">Nama Toko</th>
                        <th class="px-4 py-2 border">Total Terjual</th>
                        <th class="px-4 py-2 border">Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">

                    @forelse ($historiPenjualan as $item)
                    @php
                        $totalTerjual = 
                            $item->coklat_terjual +
                            $item->srikaya_terjual +
                            $item->strawberry_terjual +
                            $item->kacang_terjual +
                            $item->coklat_kacang_terjual +
                            $item->coklat_strawberry_terjual +
                            $item->mocca_terjual +
                            $item->kopi_terjual +
                            $item->keju_terjual;
                    @endphp

                    <tr class="hover:bg-yellow-50 transition">
                        <td class="px-4 py-2 border">
                            {{ \Carbon\Carbon::parse($item->tanggal_pengambilan)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-2 border">{{ $item->nama_toko }}</td>
                        <td class="px-4 py-2 border text-center">{{ $totalTerjual }}</td>
                        <td class="px-4 py-2 border font-semibold text-green-600">
                            Rp {{ number_format($item->total_bill, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500 italic border">
                            Belum ada data penjualan
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
