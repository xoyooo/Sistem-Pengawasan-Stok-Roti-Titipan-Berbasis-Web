<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * 🔹 Halaman utama admin
     */
    public function home()
    {
        return view('admin.home');
    }

    /**
     * 🔹 Menampilkan daftar akun sales
     */
    public function sales()
    {
        $sales = User::where('role', 'sales')->latest()->get();
        return view('admin.sales', compact('sales'));
    }

    /**
     * 🔹 Menambahkan akun sales baru
     */
    public function tambahSales(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|string|min:5',
            'phone' => 'required|string|max:20',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'role'     => 'sales',
        ]);

        return redirect()->route('admin.sales')->with('success', 'Akun sales berhasil ditambahkan.');
    }

    /**
     * 🔹 Menghapus akun sales
     */
    public function hapusSales($id)
    {
        $sales = User::findOrFail($id);

        // Cegah admin menghapus akun dirinya sendiri
        if (Auth::check() && Auth::id() === $sales->id) {
            return back()->with('error', 'Kamu tidak dapat menghapus akun kamu sendiri.');
        }

        $sales->delete();

        return redirect()->route('admin.sales')->with('success', 'Akun sales berhasil dihapus.');
    }

    /**
     * 🔹 Menampilkan daftar toko
     */
    public function daftarToko()
    {
        $stores = Store::latest()->get();
        return view('admin.daftar_toko', compact('stores'));
    }

    /**
     * 🔹 Menampilkan peta lokasi toko
     */
    public function lokasiToko()
    {
        $stores = Store::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['name', 'address', 'latitude', 'longitude']);

        return view('admin.lokasi_toko', compact('stores'));
    }

    /**
     * 🔹 Menampilkan histori (sementara kosong)
     */
    public function histori()
    {
        return view('admin.histori');
    }
}
