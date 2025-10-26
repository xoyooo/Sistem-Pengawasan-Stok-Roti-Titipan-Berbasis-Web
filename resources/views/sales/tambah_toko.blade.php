@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Tambah Toko</h1>
    <form action="#" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nama_toko" class="block text-gray-700 font-medium mb-2">Nama Toko</label>
            <input type="text" id="nama_toko" name="nama_toko"
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                placeholder="Masukkan nama toko">
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Simpan
        </button>
    </form>
</div>
@endsection
