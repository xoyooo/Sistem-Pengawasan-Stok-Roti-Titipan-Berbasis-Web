@extends('layouts.app')

@section('title', 'Daftar Toko')

@section('content')
<div class="p-4 sm:p-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Daftar Toko</h1>
        <a href="{{ route('sales.tambahtoko') }}"
           class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg shadow transition">
           + Tambah Toko
        </a>
    </div>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi error --}}
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel daftar toko --}}
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Toko</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Alamat</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No HP</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($stores as $index => $store)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-800">{{ $index + 1 }}</td>
                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-800 font-medium">{{ $store->name }}</td>
                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-800">{{ $store->address }}</td>
                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-800">{{ $store->phone }}</td>
                        <td class="px-4 sm:px-6 py-4 text-sm flex space-x-2">
                            <form action="{{ route('sales.toko.destroy', $store->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="bg-red-500 hover:bg-red-600 text-white font-semibold px-3 py-1 rounded transition delete-btn"
                                        data-name="{{ $store->name }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data toko.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function () {
        const form = this.closest('form');
        const storeName = this.dataset.name;

        Swal.fire({
            icon: 'warning',
            title: 'Hapus Toko?',
            html: `Yakin ingin menghapus toko "<strong>${storeName}</strong>"?`,
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'px-4 py-2 rounded-lg font-semibold',
                cancelButton: 'px-4 py-2 rounded-lg font-semibold'
            }
        }).then(result => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection
