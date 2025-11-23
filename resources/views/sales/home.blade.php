@extends('layouts.app')

@section('title', 'Sales - Home')
@section('page_title', 'Home')

@section('content')

{{-- ========================= --}}
{{-- TARGET BULANAN --}}
{{-- ========================= --}}
<div class="bg-yellow-50 border border-yellow-200 rounded-2xl shadow-md p-6 text-center">

    <h3 class="text-gray-700 font-semibold text-lg mb-1">Target Bulanan</h3>

    @if($target)
        <p class="text-3xl font-bold text-yellow-600 tracking-wide">
            Rp {{ number_format($target->target_bulanan, 0, ',', '.') }}
        </p>

        <p class="text-gray-700 mt-3 font-semibold">
            Sisa Target:
            <span class="text-red-500">
                Rp {{ number_format($target->sisa_target, 0, ',', '.') }}
            </span>
        </p>

        {{-- Jika target tercapai --}}
        @if($target->sisa_target <= 0)
            <div class="mt-3 inline-flex items-center bg-green-100 text-green-700 px-3 py-1 rounded-lg">
                <i class="fa-solid fa-circle-check mr-2"></i> Target Tercapai!
            </div>
        @endif

    @else
        <p class="text-gray-500">Belum ada target yang ditetapkan admin.</p>
    @endif

    <p class="text-gray-500 text-sm mt-1">
        Bulan: <b>{{ now()->format('F Y') }}</b>
    </p>
</div>

<div class="p-6 space-y-8">

    {{-- ========================= --}}
    {{-- TOTAL PENDAPATAN --}}
    {{-- ========================= --}}
    <div class="bg-white border border-yellow-200 rounded-2xl shadow-md p-6 text-center">
        <h3 class="text-gray-700 font-semibold text-lg mb-1">Total Uang Terkumpul</h3>

        <p class="text-3xl font-bold text-green-600 tracking-wide">
            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        </p>

        <p class="text-gray-500 text-sm mt-1">
            Periode: <b class="capitalize">{{ $filter }}</b>
        </p>
    </div>


    {{-- ========================= --}}
    {{-- KARTU AKSI --}}
    {{-- ========================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- Input stok --}}
        <a href="{{ route('sales.input') }}" 
           class="group bg-yellow-50 border border-yellow-100 rounded-2xl shadow-md p-8 text-center hover:shadow-lg hover:-translate-y-1 transition">
            <div class="bg-yellow-400 w-14 h-14 flex items-center justify-center rounded-lg mx-auto mb-3">
                <i class="fa-solid fa-box text-white text-2xl"></i>
            </div>
            <h3 class="font-semibold text-gray-800">Input Stok Roti</h3>
            <p class="text-gray-600 text-sm">Catat stok masuk sebelum pengantaran</p>
        </a>

        {{-- Input sisa --}}
        <a href="{{ route('sales.sisa.create') }}" 
           class="group bg-yellow-50 border border-yellow-100 rounded-2xl shadow-md p-8 text-center hover:shadow-lg hover:-translate-y-1 transition">
            <div class="bg-yellow-400 w-14 h-14 flex items-center justify-center rounded-lg mx-auto mb-3">
                <i class="fa-solid fa-clipboard-check text-white text-2xl"></i>
            </div>
            <h3 class="font-semibold text-gray-800">Input Sisa Roti</h3>
            <p class="text-gray-600 text-sm">Catat sisa roti setelah pengambilan</p>
        </a>

        {{-- lokasi toko --}}
        <a href="{{ route('sales.lokasi') }}" 
           class="group bg-yellow-50 border border-yellow-100 rounded-2xl shadow-md p-8 text-center hover:shadow-lg hover:-translate-y-1 transition">
            <div class="bg-yellow-400 w-14 h-14 flex items-center justify-center rounded-lg mx-auto mb-3">
                <i class="fa-solid fa-location-dot text-white text-2xl"></i>
            </div>
            <h3 class="font-semibold text-gray-800">Lihat Lokasi Toko</h3>
            <p class="text-gray-600 text-sm">Lihat daftar lokasi toko mitra</p>
        </a>

    </div>


    {{-- ========================= --}}
    {{-- TABEL RIWAYAT PENJUALAN --}}
    {{-- ========================= --}}
    <div class="bg-white border border-yellow-200 rounded-2xl shadow-md p-6">

        {{-- HEADER TABEL + FILTER --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-3">

            <h3 class="text-gray-700 font-semibold text-lg">
                Riwayat Penjualan
            </h3>

            {{-- FILTER PERIODE DI DALAM TABEL --}}
            <form method="GET" class="flex gap-3 items-center">

                <select name="filter"
                        class="px-4 py-2 border rounded-lg bg-white">
                    <option value="semua" {{ ($filter ?? '') == 'semua' ? 'selected' : '' }}>Semua</option>
                    <option value="hari" {{ ($filter ?? '') == 'hari' ? 'selected' : '' }}>Harian</option>
                    <option value="minggu" {{ ($filter ?? '') == 'minggu' ? 'selected' : '' }}>Mingguan</option>
                    <option value="bulan" {{ ($filter ?? '') == 'bulan' ? 'selected' : '' }}>Bulanan</option>
                </select>

                <button class="px-5 py-2 bg-yellow-400 hover:bg-yellow-500 rounded-lg shadow">
                    Terapkan
                </button>

            </form>
        </div>

        {{-- TABLE --}}
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
                                Belum ada data penjualan untuk periode ini
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
