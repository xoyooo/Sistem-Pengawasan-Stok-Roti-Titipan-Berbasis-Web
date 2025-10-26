<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StokRoti;

class SalesController extends Controller
{
    public function home()
    {
        return view('sales.home');
    }

    public function create()
    {
        return view('sales.input_stok');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'toko_id' => 'required|integer',
            'jumlah_roti' => 'required|integer|min:1',
            'tanggal_pengantaran' => 'required|date',
            'foto_roti' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('foto_roti')) {
            $path = $request->file('foto_roti')->store('foto_roti', 'public');
        }

        $stok = new StokRoti();
        $stok->user_id = Auth::id();
        $stok->toko_id = $request->toko_id;
        $stok->jumlah_roti = $request->jumlah_roti;
        $stok->tanggal_pengantaran = $request->tanggal_pengantaran;
        $stok->foto_roti = $path;
        $stok->save();

        return redirect()->route('sales.input')->with('success', 'Data stok roti berhasil disimpan!');
    }


    
     public function histori()
    {
        return view('sales.histori');
    }

    public function lokasi()
    {
        return view('sales.lokasi_toko');
    }

    public function daftarToko()
    {
        return view('sales.daftar_toko');
    }

    public function tambahToko()
    {
        return view('sales.tambah_toko');
    }
}
