<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StokRoti;
use App\Models\Store;
use Carbon\Carbon;


class SalesController extends Controller
{
    /** 🏠 Halaman Home */
   public function home()
    {
    $stores = Store::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get(['name', 'address', 'latitude', 'longitude']);

    return view('sales.home', compact('stores'));
    }


    /** 🧾 Histori Penjualan */
    public function histori()
    {
        // Ambil sales_id dari user yang login
        $salesId = Auth::user()->id;

        // Ambil data 7 hari terakhir berdasarkan tanggal_pengantaran
        $histori = StokRoti::with('store')
            ->where('user_id', $salesId)
            ->where('tanggal_pengantaran', '>=', Carbon::now()->subDays(7))
            ->orderBy('tanggal_pengantaran', 'desc')
            ->get();

        return view('sales.histori', compact('histori'));
    }

    /** 📍 Lokasi Toko */
    public function lokasi()
    {
        // Ambil semua data toko dari tabel stores
        $stores = Store::all();
        return view('sales.lokasi_toko', compact('stores'));
    }

    /** 📦 Form Input Stok Roti */
    public function create()
    {
        // Ambil daftar toko milik sales yang sedang login
        $stores = \App\Models\Store::where('sales_id', Auth::id())->get();

        return view('sales.input_stok', compact('stores'));
    }

    /** ✅ Simpan Inputan Harian */
    public function storeStok(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'jumlah_roti' => 'required|integer|min:1',
            'jumlah_sisa' => 'required|integer|min:0',
            'tanggal_pengantaran' => 'required|date',
            'foto_roti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_sisa' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // ✅ Simpan foto roti
        $fotoRotiPath = $request->hasFile('foto_roti')
            ? $request->file('foto_roti')->store('uploads/foto_roti', 'public')
            : null;

        // ✅ Simpan foto sisa roti
        $fotoSisaPath = $request->hasFile('foto_sisa')
            ? $request->file('foto_sisa')->store('uploads/foto_sisa', 'public')
            : null;

        // ✅ Simpan ke database
        StokRoti::create([
            'user_id' => Auth::id(),
            'nama_toko' => $request->nama_toko,
            'jumlah_roti' => $request->jumlah_roti,
            'jumlah_sisa' => $request->jumlah_sisa,
            'tanggal_pengantaran' => Carbon::parse($request->tanggal_pengantaran)->format('Y-m-d'),
            'foto_roti' => $fotoRotiPath,
            'foto_sisa' => $fotoSisaPath,
        ]);

        return redirect()->route('sales.histori')->with('success', 'Data stok berhasil disimpan!');
    }

    /* ===============================
       📍 Update Lokasi Toko
    =============================== */
    public function updateLokasi(Request $request, $id)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $store = Store::findOrFail($id);
        $store->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->back()->with('success', 'Lokasi toko berhasil diperbarui!');
    }

}
