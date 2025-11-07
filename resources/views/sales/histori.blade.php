@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-6 text-green-600">Histori Penjualan (7 Hari Terakhir)</h1>

    @if($histori->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
            Tidak ada data penjualan dalam 7 hari terakhir.
        </div>
    @else
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-green-500 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-left">Nama Toko</th>
                        <th class="px-4 py-3 text-left">Jumlah Roti</th>
                        <th class="px-4 py-3 text-left">Jumlah Sisa</th>
                        <th class="px-4 py-3 text-left">Foto Roti</th>
                        <th class="px-4 py-3 text-left">Foto Sisa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histori as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal_pengantaran)->format('d M Y') }}</td>
                            <td class="px-4 py-3">{{ $item->nama_toko ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $item->jumlah_roti }}</td>
                            <td class="px-4 py-3">{{ $item->jumlah_sisa }}</td>
                            <td class="px-4 py-3">
                                @if($item->foto_roti)
                                    <img src="{{ asset('storage/'.$item->foto_roti) }}" 
                                        alt="Foto Roti" class="w-16 h-16 rounded object-cover">
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif

                            </td>
                            <td class="px-4 py-3">
                                {{-- Foto Sisa --}}
                                @if($item->foto_sisa)
                                    <img src="{{ asset('storage/'.$item->foto_sisa) }}" ...
                                        alt="Foto Sisa" class="w-16 h-16 rounded object-cover">
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
