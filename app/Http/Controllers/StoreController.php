<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Store;

class StoreController extends Controller
{
    /** 🧭 Tampilkan daftar toko */
    public function index()
    {
        $stores = Store::where('sales_id', Auth::id())->latest()->get();
        return view('sales.daftar_toko', compact('stores'));
    }

    /** ➕ Form tambah toko */
    public function create()
    {
        return view('sales.tambah_toko');
    }

    /** 💾 Simpan toko baru */
    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'owner_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'join_date' => 'required|date',
            'photo.*' => 'required|image|mimes:jpg,jpeg,png|max:5120', // ubah ke photo.*
        ]);

        $paths = [];
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $file) {
                $paths[] = $file->store('foto_toko', 'public');
            }
        }

        Store::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'owner_name' => $validated['owner_name'],
            'address' => $validated['address'],
            'join_date' => $validated['join_date'],
            'photo' => json_encode($paths), // simpan array foto jadi JSON
            'sales_id' => Auth::id(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data toko berhasil disimpan!',
            ]);
        }

        return redirect()
            ->route('sales.daftartoko')
            ->with('success', 'Data toko berhasil disimpan!');
    } catch (\Exception $e) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data toko: ' . $e->getMessage(),
            ]);
        }

        return back()->with('error', 'Gagal menyimpan data toko: ' . $e->getMessage());
    }
}
}
