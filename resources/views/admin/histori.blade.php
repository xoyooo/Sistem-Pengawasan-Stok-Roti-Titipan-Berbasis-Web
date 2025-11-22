@extends('layouts.admin')

@section('title', 'Histori Penjualan')

@section('content')

<div class="p-4 sm:p-8">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Histori Penjualan (7 Hari Terakhir)
    </h1>

    @if ($histori->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
            Belum ada histori penjualan dalam 7 hari terakhir.
        </div>
    @else

        {{-- ========================= --}}
        {{-- DESKTOP TABLE --}}
        {{-- ========================= --}}
        <div class="hidden sm:block bg-white shadow rounded-lg overflow-x-auto mb-6">
            <table class="min-w-full border-collapse">
                <thead class="bg-yellow-300 text-black">
                    <tr>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-left">Sales</th>
                        <th class="px-4 py-3 text-left">Nama Toko</th>
                        <th class="px-4 py-3 text-left">Jumlah Roti</th>
                        <th class="px-4 py-3 text-left">Jumlah Sisa</th>
                        <th class="px-4 py-3 text-left">Foto Roti</th>
                        <th class="px-4 py-3 text-left">Foto Sisa</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach ($histori as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal_pengantaran)->format('d M Y') }}</td>
                            <td class="px-4 py-3">{{ $item->user->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $item->nama_toko }}</td>
                            <td class="px-4 py-3">{{ $item->jumlah_roti }}</td>
                            <td class="px-4 py-3">{{ $item->jumlah_sisa }}</td>

                            <td class="px-4 py-3">
                                @if($item->foto_roti)
                                    <img src="{{ asset('storage/'.$item->foto_roti) }}"
                                         class="w-16 h-16 rounded object-cover">
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                @if($item->foto_sisa)
                                    <img src="{{ asset('storage/'.$item->foto_sisa) }}"
                                         class="w-16 h-16 rounded object-cover">
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        {{-- ========================= --}}
        {{-- MOBILE CARD VIEW --}}
        {{-- ========================= --}}
        <div class="sm:hidden space-y-4 mb-6">

            @foreach ($histori as $item)
                <div class="bg-white rounded-lg shadow p-4">

                    <p class="text-sm text-gray-600 mb-1">
                        {{ \Carbon\Carbon::parse($item->tanggal_pengantaran)->format('d M Y') }}
                    </p>

                    <p><b>Sales:</b> {{ $item->user->name }}</p>
                    <p><b>Toko:</b> {{ $item->nama_toko }}</p>
                    <p><b>Jumlah Roti:</b> {{ $item->jumlah_roti }}</p>
                    <p><b>Sisa:</b> {{ $item->jumlah_sisa }}</p>

                    <div class="flex gap-4 mt-3">

                        {{-- Foto Roti --}}
                        @if($item->foto_roti)
                            <img src="{{ asset('storage/'.$item->foto_roti) }}"
                                 class="w-20 h-20 rounded object-cover shadow">
                        @else
                            <div class="w-20 h-20 rounded bg-gray-200 flex items-center justify-center text-gray-500">
                                -
                            </div>
                        @endif

                        {{-- Foto Sisa --}}
                        @if($item->foto_sisa)
                            <img src="{{ asset('storage/'.$item->foto_sisa) }}"
                                 class="w-20 h-20 rounded object-cover shadow">
                        @else
                            <div class="w-20 h-20 rounded bg-gray-200 flex items-center justify-center text-gray-500">
                                -
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach

        </div>

    @endif
</div>

@endsection
