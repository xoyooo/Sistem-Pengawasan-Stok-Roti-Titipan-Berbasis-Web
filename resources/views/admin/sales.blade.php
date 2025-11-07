@extends('layouts.admin')

@section('title', 'Daftar Sales')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-6">Daftar Sales</h2>

    <!-- ✅ Notifikasi sukses -->
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- ⚠️ Notifikasi error -->
    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 📋 Tabel Daftar Sales -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="py-3 px-4 text-left">Nama</th>
                    <th class="py-3 px-4 text-left">Username</th>
                    <th class="py-3 px-4 text-left">Password</th>
                    <th class="py-3 px-4 text-left">No. Telepon</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($sales as $item)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $item->name }}</td>
                        <td class="py-3 px-4">{{ $item->username }}</td>
                        <td class="py-3 px-4 select-none">••••••</td>
                        <td class="py-3 px-4">{{ $item->phone }}</td>
                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('admin.sales.hapus', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data sales.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ➕ Tombol Tambah -->
    <div class="fixed bottom-8 right-8">
        <button 
            onclick="document.getElementById('popup').classList.remove('hidden')" 
            class="bg-green-600 text-white p-4 rounded-full shadow-lg hover:bg-green-700 transition"
        >
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>

    <!-- 🪟 Popup Tambah Sales -->
    <div id="popup" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative animate-fadeIn">
            <button 
                onclick="document.getElementById('popup').classList.add('hidden')" 
                class="absolute top-2 right-3 text-gray-400 hover:text-gray-600"
            >
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <h3 class="text-xl font-semibold mb-4 text-center">Tambah Akun Sales</h3>

            <form action="{{ route('admin.sales.tambah') }}" method="POST" autocomplete="off">
                @csrf
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Nama</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Username</label>
                    <input type="text" name="username" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Password</label>
                    <input type="password" name="password" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium">No. Telepon</label>
                    <input type="text" name="phone" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none" required>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" 
                            onclick="document.getElementById('popup').classList.add('hidden')" 
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ✨ Animasi sederhana -->
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn { animation: fadeIn 0.2s ease-in-out; }
</style>
@endsection
