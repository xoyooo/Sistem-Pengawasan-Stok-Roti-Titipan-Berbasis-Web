<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\StokRoti;
use App\Models\Store;
use Carbon\Carbon;

class SalesController extends Controller
{
    /** 🏠 Halaman Home */
    public function home()
    {
        $salesId = Auth::id();

        // Total Uang Terkumpul
        $totalPendapatan = \App\Models\SisaRoti::where('user_id', $salesId)->sum('total_bill');

        // Data tabel penjualan
        $historiPenjualan = \App\Models\SisaRoti::where('user_id', $salesId)
            ->orderBy('tanggal_pengambilan', 'desc')
            ->get();

        return view('sales.home', compact('totalPendapatan', 'historiPenjualan'));
    }

    /** 📜 Histori Stok Masuk */
    public function histori()
    {
        $salesId = Auth::id();

        $histori = StokRoti::where('user_id', $salesId)
            ->orderBy('tanggal_pengantaran', 'desc')
            ->get();

        return view('sales.histori', compact('histori'));
    }

    /** 📍 Lokasi Toko */
    public function lokasi()
    {
        $stores = Store::where('sales_id', Auth::id())->get();
        return view('sales.lokasi_toko', compact('stores'));
    }

    /** 📦 Form Input Stok */
    public function create()
    {
        $stores = Store::where('sales_id', Auth::id())->get();

        // Ambil varian dari kolom stok_rotis
        $columns = Schema::getColumnListing('stok_rotis');
        $variants = [];
        foreach ($columns as $col) {
            if (str_contains($col, '_masuk')) {
                $variants[] = str_replace('_masuk', '', $col);
            }
        }

        return view('sales.input_stok', compact('stores', 'variants'));
    }

    /** 📝 Simpan Input Stok */
    public function storeStok(Request $request)
    {
        // Ambil varian otomatis dari database
        $columns = Schema::getColumnListing('stok_rotis');
        $variants = [];
        foreach ($columns as $col) {
            if (str_contains($col, '_masuk')) {
                $variants[] = str_replace('_masuk', '', $col);
            }
        }

        // Validasi
        $rules = [
            'nama_toko' => 'required|string|max:255',
            'tanggal_pengantaran' => 'required|date',
            'foto_roti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        foreach ($variants as $v) {
            $rules[$v . '_masuk'] = 'required|integer|min:0';
        }

        $request->validate($rules);

        // Upload foto
        $fotoRotiPath = $request->hasFile('foto_roti')
            ? $request->file('foto_roti')->store('uploads/foto_roti', 'public')
            : null;

        // Siapkan data simpan
        $data = [
            'user_id' => Auth::id(),
            'nama_toko' => $request->nama_toko,
            'tanggal_pengantaran' => Carbon::parse($request->tanggal_pengantaran)->format('Y-m-d'),
            'foto_roti' => $fotoRotiPath,
        ];

        foreach ($variants as $v) {
            $data[$v . '_masuk'] = $request->input($v . '_masuk', 0);
        }

        StokRoti::create($data);

        return redirect()->route('sales.histori')->with('success', 'Data stok berhasil disimpan!');
    }

    /** 🌍 Update Lokasi Toko */
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
