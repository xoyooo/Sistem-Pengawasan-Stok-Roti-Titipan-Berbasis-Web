@extends('layouts.admin')

@section('title', 'Target Sales')

@section('content')
<div class="p-4 sm:p-8">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Target Sales Bulanan</h1>

    {{-- Filter bulan --}}
    <form method="GET" class="mb-5 flex gap-3">
        <input type="month" name="bulan"
               value="{{ date('Y-m', strtotime($bulan)) }}"
               class="px-3 py-2 border rounded-lg" />
        <button class="bg-yellow-400 hover:bg-yellow-500 px-4 py-2 rounded-lg font-semibold">
            Terapkan
        </button>
    </form>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel --}}
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full border-collapse">
            <thead class="bg-yellow-300">
                <tr>
                    <th class="px-4 py-3 text-left">Nama Sales</th>
                    <th class="px-4 py-3 text-left">Target Bulanan</th>
                    <th class="px-4 py-3 text-left">Sudah Tercapai</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach ($salesData as $row)
                    <tr class="hover:bg-gray-50">

                        <td class="px-4 py-3">
                            {{ $row['sales']->name }}
                        </td>

                        <td class="px-4 py-3 font-semibold">
                            Rp {{ number_format($row['target']->target_bulanan, 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-3 text-green-600 font-bold">
                            Rp {{ number_format($row['target']->tercapai, 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-3">
                            @if($row['target']->tercapai >= $row['target']->target_bulanan && $row['target']->target_bulanan > 0)
                                <span class="text-green-600 font-bold">
                                    <i class="fa-solid fa-circle-check"></i> Tercapai
                                </span>
                            @else
                                <span class="text-red-500 font-bold">
                                    <i class="fa-solid fa-circle-xmark"></i> Belum
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            <button onclick="openEditTarget(
                                '{{ $row['sales']->id }}',
                                '{{ $row['target']->target_bulanan }}'
                                )"
                                class="bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-white">
                                Edit
                            </button>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- Modal Edit Target --}}
<div id="editModal"
     class="fixed inset-0 bg-black/40 hidden justify-center items-center p-4 z-[999]">

    <div class="bg-white rounded-lg p-6 w-full max-w-sm relative">

        <h2 class="text-xl font-bold mb-3">Edit Target Sales</h2>

        <form method="POST" action="{{ route('admin.target.update') }}">
            @csrf

            <input type="hidden" id="edit_user_id" name="user_id">
            <input type="hidden" name="bulan" value="{{ $bulan }}">

            <label class="font-semibold">Target Bulanan (Rp)</label>
            <input type="number" id="edit_target" name="target_bulanan"
                   class="w-full border rounded px-3 py-2 mt-1 mb-4" required>

            <button class="bg-yellow-400 hover:bg-yellow-500 w-full py-2 rounded">
                Simpan
            </button>
        </form>

        <button onclick="closeEditModal()"
            class="absolute top-2 right-3 text-gray-600 hover:text-black">
            ✖
        </button>
    </div>
</div>


<script>
function openEditTarget(id, target) {
    document.getElementById('edit_user_id').value = id;
    document.getElementById('edit_target').value = target;

    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}
</script>

@endsection
