@extends('layouts.admin')

@section('title', 'Statistik Penjualan')

@section('content')
<div class="p-4 sm:p-8">

    <h1 class="text-2xl font-bold mb-6 text-gray-800">Statistik Penjualan</h1>

    {{-- ======================== --}}
    {{-- FILTER UNTUK CHART --}}
    {{-- ======================== --}}
    <form method="GET" class="mb-6 grid grid-cols-1 sm:grid-cols-3 gap-4">

        <input type="text" 
               name="toko"
               value="{{ request('toko') }}"
               placeholder="Cari nama toko..."
               class="px-4 py-2 border rounded-lg">

        <select name="filter" class="px-4 py-2 border rounded-lg">
            <option value="hari"   {{ $filter=='hari' ? 'selected' : '' }}>Harian</option>
            <option value="minggu" {{ $filter=='minggu' ? 'selected' : '' }}>Mingguan</option>
            <option value="bulan"  {{ $filter=='bulan' ? 'selected' : '' }}>Bulanan</option>
            <option value="semua"  {{ $filter=='semua' ? 'selected' : '' }}>Semua</option>
        </select>

        <button class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 rounded-lg font-semibold">
            Terapkan
        </button>
    </form>


    {{-- ===================================================== --}}
    {{--  BAGIAN 1: DIAGRAM BATANG PENJUALAN PER RASA --}}
    {{-- ===================================================== --}}
    <div class="bg-white shadow rounded-lg p-6 mb-10">
        <h2 class="text-xl font-bold mb-4">Penjualan per Rasa</h2>

        @if(count($rasaData) == 0)
            <p class="text-gray-500">Belum ada data penjualan pada periode ini.</p>
        @else
            <canvas id="chartRoti"></canvas>
        @endif
    </div>



    {{-- ===================================================== --}}
    {{--  BAGIAN 2: FILTER PERFORMA SALES (BERDIRI SENDIRI) --}}
    {{-- ===================================================== --}}
    <form method="GET" class="mb-4 flex gap-4">

        {{-- Filter Sales --}}
        <select name="filter_sales"
                onchange="this.form.submit()"
                class="px-4 py-2 border rounded-lg bg-white">

            <option value="hari"   {{ $filterSales=='hari' ? 'selected' : '' }}>Hari Ini</option>
            <option value="minggu" {{ $filterSales=='minggu' ? 'selected' : '' }}>7 Hari Terakhir</option>
            <option value="bulan"  {{ $filterSales=='bulan' ? 'selected' : '' }}>30 Hari Terakhir</option>
            <option value="semua"  {{ $filterSales=='semua' ? 'selected' : '' }}>Semua Data</option>

        </select>

        {{-- Jaga agar filter chart tetap dipertahankan --}}
        <input type="hidden" name="toko" value="{{ $toko }}">
        <input type="hidden" name="filter" value="{{ $filter }}">
    </form>


    {{-- ===================================================== --}}
    {{--  BAGIAN 3: PERFORMA SALES --}}
    {{-- ===================================================== --}}
    <div class="bg-white shadow rounded-lg p-6">

        <h2 class="text-xl font-bold mb-4">Performa Sales</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            @foreach($salesPerformance as $sales => $data)
            <div class="p-4 border rounded-lg shadow bg-yellow-50">
                <h3 class="font-semibold text-lg mb-2">{{ $sales }}</h3>

                <p class="text-gray-800">
                    <b>Total Terjual:</b> {{ $data['total_terjual'] }} roti
                </p>

                <p class="text-green-600 font-bold">
                    Rp {{ number_format($data['total_uang'], 0, ',', '.') }}
                </p>
            </div>
            @endforeach

        </div>

    </div>

</div>


{{-- ===================================================== --}}
{{--  SCRIPT CHART --}}
{{-- ===================================================== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('chartRoti');

    @if(count($rasaData) > 0)
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($rasaData)) !!},
            datasets: [{
                label: 'Jumlah Terjual',
                data: {!! json_encode(array_values($rasaData)) !!},
                backgroundColor: '#FACC15'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
    @endif
</script>

@endsection
