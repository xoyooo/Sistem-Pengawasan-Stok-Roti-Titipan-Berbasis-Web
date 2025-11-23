@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<div class="p-4 sm:p-8 space-y-10">

    {{-- ========================================================= --}}
    {{--  RINGKASAN KARTU --}}
    {{-- ========================================================= --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

        <div class="bg-white border border-yellow-200 p-6 rounded-2xl shadow">
            <p class="text-gray-600 text-sm">Penjualan Hari Ini</p>
            <h2 class="text-2xl font-bold text-green-600">
                Rp {{ number_format($totalHariIni, 0, ',', '.') }}
            </h2>
        </div>

        <div class="bg-white border border-yellow-200 p-6 rounded-2xl shadow">
            <p class="text-gray-600 text-sm">Penjualan Bulan Ini</p>
            <h2 class="text-2xl font-bold text-yellow-600">
                Rp {{ number_format($totalBulanIni, 0, ',', '.') }}
            </h2>
        </div>

        <div class="bg-white border border-yellow-200 p-6 rounded-2xl shadow">
            <p class="text-gray-600 text-sm">Jumlah Sales</p>
            <h2 class="text-2xl font-bold text-gray-800">
                {{ $jumlahSales }}
            </h2>
        </div>

        <div class="bg-white border border-yellow-200 p-6 rounded-2xl shadow">
            <p class="text-gray-600 text-sm">Jumlah Toko</p>
            <h2 class="text-2xl font-bold text-gray-800">
                {{ $jumlahToko }}
            </h2>
        </div>

    </div>




    {{-- ========================================================= --}}
    {{--  GRAFIK PENJUALAN 7 HARI --}}
    {{-- ========================================================= --}}
    <div class="bg-white border border-yellow-200 p-6 rounded-2xl shadow">

        <h2 class="text-xl font-bold mb-4">Penjualan 7 Hari Terakhir</h2>

        <canvas id="chartPenjualan"></canvas>

    </div>




    {{-- ========================================================= --}}
    {{--  TOP SALES MINGGU INI --}}
    {{-- ========================================================= --}}
    <div class="bg-white border border-yellow-200 p-6 rounded-2xl shadow">

        <h2 class="text-xl font-bold mb-4">Top Sales Minggu Ini</h2>

        @if($topSales->isEmpty())
            <p class="text-gray-500">Belum ada data penjualan minggu ini.</p>
        @else
            <div class="space-y-3">
                @foreach($topSales as $index => $row)
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold">{{ $row->user->name }}</span>
                        <span class="text-green-600 font-bold">
                            Rp {{ number_format($row->total, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif

    </div>




    {{-- ========================================================= --}}
    {{--  AKTIVITAS TERBARU --}}
    {{-- ========================================================= --}}
    <div class="bg-white border border-yellow-200 p-6 rounded-2xl shadow">

        <h2 class="text-xl font-bold mb-4">Aktivitas Terbaru</h2>

        @if($aktivitas->isEmpty())
            <p class="text-gray-500">Belum ada aktivitas terbaru.</p>
        @else
            @foreach($aktivitas as $item)
                <div class="border-b py-2">
                    <b>{{ $item->user->name ?? 'Sales' }}</b>
                    melakukan input sisa roti di
                    <b>{{ $item->nama_toko }}</b>
                    sebesar
                    <span class="text-green-600 font-bold">
                        Rp {{ number_format($item->total_bill, 0, ',', '.') }}
                    </span>
                    <br>
                    <small class="text-gray-500">
                        {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                    </small>
                </div>
            @endforeach
        @endif

    </div>




    {{-- ========================================================= --}}
    {{--  NOTIFIKASI TARGET --}}
    {{-- ========================================================= --}}
    <div class="bg-white border border-yellow-200 p-6 rounded-2xl shadow">

        <h2 class="text-xl font-bold mb-4">Status Target Bulanan</h2>

        @if($targetSales->isEmpty())
            <p class="text-gray-500">Belum ada target bulan ini.</p>
        @else
            <div class="space-y-3">
                @foreach($targetSales as $row)
                    <div class="flex justify-between border-b pb-2">
                        <span>{{ $row->user->name }}</span>

                        @php
                            $tercapai = $row->tercapai >= $row->target_bulanan;
                        @endphp

                        <span class="{{ $tercapai ? 'text-green-600' : 'text-red-500' }} font-bold">
                            {{ $tercapai ? 'Tercapai' : 'Belum' }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

</div>


{{-- ========================================================= --}}
{{--  SCRIPT CHART --}}
{{-- ========================================================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('chartPenjualan');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($tanggal) !!},
        datasets: [{
            label: 'Penjualan (Rp)',
            data: {!! json_encode($penjualan) !!},
            borderColor: '#FACC15',
            backgroundColor: '#FDE047',
            tension: 0.3,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>

@endsection
