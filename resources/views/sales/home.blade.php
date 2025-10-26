@extends('layouts.app')

@section('title', 'Sales - Home')
@section('page_title', 'Home')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    <a href="{{ route('sales.input') }}" class="bg-green-500 text-white font-semibold text-center p-8 rounded-lg hover:bg-green-600 transition">
        Input Stok Roti
    </a>
    <a href="{{ route('sales.lokasi') }}" class="bg-green-500 text-white font-semibold text-center p-8 rounded-lg hover:bg-green-600 transition">
        Lihat Daftar Toko
    </a>
</div>
@endsection
