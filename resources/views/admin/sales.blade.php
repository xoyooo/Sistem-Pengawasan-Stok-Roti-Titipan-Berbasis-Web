@extends('layouts.admin')

@section('title', 'Daftar Sales')

@section('content')
<div class="p-6">

    <h2 class="text-2xl font-semibold mb-6">Daftar Sales</h2>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi Error --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- =============================
        DESKTOP TABLE (HEADER KUNING)
    ============================= --}}
    <div class="hidden sm:block overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">

            <thead class="bg-yellow-400 text-black font-semibold">
                <tr>
                    <th class="py-3 px-4 text-left">Nama</th>
                    <th class="py-3 px-4 text-left">Username</th>
                    <th class="py-3 px-4 text-left">Password</th>
                    <th class="py-3 px-4 text-left">Telepon</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">
                @foreach($sales as $s)
                <tr class="border-b hover:bg-yellow-50 transition">

                    <td class="py-3 px-4">{{ $s->name }}</td>
                    <td class="py-3 px-4">{{ $s->username }}</td>

                    <td class="py-3 px-4">
                        <span id="pw-text-{{ $s->id }}">••••••</span>
                        <button onclick="togglePassword({{ $s->id }})"
                                class="text-blue-500 ml-1">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </td>

                    <td class="py-3 px-4">{{ $s->phone }}</td>

                    <td class="py-3 px-4 text-center flex items-center gap-3 justify-center">

                        {{-- EDIT --}}
                        <button onclick="openEditSales('{{ $s->id }}', '{{ $s->name }}', '{{ $s->username }}', '{{ $s->phone }}')"
                                class="text-yellow-600 hover:text-yellow-700">
                            <i class="fa-solid fa-pen"></i>
                        </button>

                        {{-- HAPUS --}}
                        <form action="{{ route('admin.sales.hapus', $s->id) }}"
                              method="POST"
                              onsubmit="deleteConfirm(event)">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:text-red-700">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    {{-- =============================
        MOBILE CARD (KUNING)
    ============================= --}}
    <div class="block sm:hidden space-y-4">

        @foreach($sales as $s)
        <div class="bg-yellow-50 p-4 rounded-lg shadow">

            <p><b>Nama:</b> {{ $s->name }}</p>
            <p><b>Username:</b> {{ $s->username }}</p>

            <p>
                <b>Password:</b>
                <span id="m-pw-{{ $s->id }}">••••••</span>
                <button onclick="toggleMobilePassword({{ $s->id }})"
                        class="text-blue-500 ml-1">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </p>

            <p><b>Telepon:</b> {{ $s->phone }}</p>

            <div class="flex gap-2 mt-3">

                <button onclick="openEditSales('{{ $s->id }}', '{{ $s->name }}', '{{ $s->username }}', '{{ $s->phone }}')"
                        class="w-1/2 bg-yellow-400 text-white py-2 rounded-lg">
                    Edit
                </button>

                <form action="{{ route('admin.sales.hapus', $s->id) }}"
                      method="POST" class="w-1/2"
                      onsubmit="deleteConfirm(event)">
                    @csrf
                    @method('DELETE')
                    <button class="w-full bg-red-500 text-white py-2 rounded-lg">
                        Hapus
                    </button>
                </form>

            </div>

        </div>
        @endforeach

    </div>


    {{-- Floating Add Button --}}
    <div class="fixed bottom-8 right-8">
        <button onclick="document.getElementById('popup').classList.remove('hidden')"
            class="bg-yellow-400 text-white p-4 rounded-full shadow-lg hover:bg-yellow-500">
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>


    {{-- =============================
        POPUP TAMBAH SALES (KUNING)
    ============================= --}}
    <div id="popup"
        class="hidden fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm z-50">

        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative animate-fadeIn">

            <button onclick="document.getElementById('popup').classList.add('hidden')"
                class="absolute top-2 right-3 text-gray-500 hover:text-black">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <h3 class="text-xl font-semibold mb-4 text-center">Tambah Sales</h3>

            <form action="{{ route('admin.sales.tambah') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="font-medium">Nama</label>
                    <input name="name" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-3">
                    <label class="font-medium">Username</label>
                    <input name="username" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-3">
                    <label class="font-medium">Password</label>
                    <input name="password" type="password" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="font-medium">Telepon</label>
                    <input name="phone" class="w-full border rounded px-3 py-2" required>
                </div>

                <button class="w-full bg-yellow-400 hover:bg-yellow-500 text-white py-2 rounded">
                    Simpan
                </button>

            </form>

        </div>

    </div>


    {{-- =============================
        POPUP EDIT SALES (KUNING)
    ============================= --}}
    <div id="editSalesPopup"
        class="hidden fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm z-50">

        <div class="bg-white w-96 rounded-lg shadow-lg p-6 relative animate-fadeIn">

            <button onclick="document.getElementById('editSalesPopup').classList.add('hidden')"
                class="absolute top-2 right-3 text-gray-500 hover:text-black">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <h3 class="text-xl font-semibold mb-4 text-center">Edit Sales</h3>

            <form id="editSalesForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="font-medium">Nama</label>
                    <input id="edit_sales_name" name="name" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-3">
                    <label class="font-medium">Username</label>
                    <input id="edit_sales_username" name="username" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-3">
                    <label class="font-medium">Password (Opsional)</label>
                    <input type="password" name="password" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="font-medium">Telepon</label>
                    <input id="edit_sales_phone" name="phone" class="w-full border rounded px-3 py-2" required>
                </div>

                <button class="w-full bg-yellow-400 hover:bg-yellow-500 text-white py-2 rounded">
                    Simpan Perubahan
                </button>

            </form>

        </div>

    </div>


</div>

{{-- =========================================
     JAVASCRIPT
========================================= --}}
<script>
function togglePassword(id) {
    const el = document.getElementById("pw-text-" + id);
    el.innerText = (el.innerText === "••••••") ? "********" : "••••••";
}

function toggleMobilePassword(id) {
    const el = document.getElementById("m-pw-" + id);
    el.innerText = (el.innerText === "••••••") ? "********" : "••••••";
}

function openEditSales(id, name, username, phone) {
    document.getElementById("edit_sales_name").value = name;
    document.getElementById("edit_sales_username").value = username;
    document.getElementById("edit_sales_phone").value = phone;

    document.getElementById("editSalesForm").action = "/admin/sales/" + id;

    document.getElementById("editSalesPopup").classList.remove("hidden");
}

function deleteConfirm(e) {
    if(!confirm("Hapus akun sales ini?")) {
        e.preventDefault();
    }
}
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn { animation: fadeIn 0.2s ease-in-out; }
</style>

@endsection
