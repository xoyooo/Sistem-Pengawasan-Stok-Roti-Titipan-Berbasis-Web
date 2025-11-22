<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function home()
    {
        return view('admin.home');
    }

    // =============================
    // SALES
    // =============================
    public function sales()
    {
        $sales = User::where('role', 'sales')->latest()->get();
        return view('admin.sales', compact('sales'));
    }

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
            'plain_password' => $request->password, // >>> SIMPAN PASSWORD ASLI
            'phone'    => $request->phone,
            'role'     => 'sales',
        ]);

        return redirect()->route('admin.sales')->with('success', 'Akun sales berhasil ditambahkan.');
    }

    public function updateSales(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:5',
        ]);

        $sales = User::findOrFail($id);

        $sales->name = $request->name;
        $sales->username = $request->username;
        $sales->phone = $request->phone;

        if ($request->password) {
            $sales->password = Hash::make($request->password);
            $sales->plain_password = $request->password;
        }

        $sales->save();

        return redirect()->route('admin.sales')->with('success', 'Akun sales berhasil diperbarui.');
    }

    public function hapusSales($id)
    {
        $sales = User::findOrFail($id);

        if (Auth::check() && Auth::id() === $sales->id) {
            return back()->with('error', 'Tidak bisa menghapus akun kamu sendiri.');
        }

        $sales->delete();

        return redirect()->route('admin.sales')->with('success', 'Akun sales berhasil dihapus.');
    }

    // =============================
    // TOKO
    // =============================
    public function daftarToko()
    {
        $stores = Store::latest()->get();
        return view('admin.daftar_toko', compact('stores'));
    }

    public function updateToko(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $store = Store::findOrFail($id);
        $store->update($request->only('name', 'address', 'phone'));

        return redirect()->route('admin.daftartoko')->with('success', 'Toko berhasil diperbarui.');
    }

    public function hapusToko($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()->route('admin.daftartoko')->with('success', 'Toko berhasil dihapus.');
    }

    // =============================
    // LOKASI TOKO
    // =============================
    public function lokasiToko()
    {
        $stores = Store::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['name', 'address', 'latitude', 'longitude']);

        return view('admin.lokasi_toko', compact('stores'));
    }

 public function histori()
{
    $histori = \App\Models\StokRoti::with('user')
        ->where('tanggal_pengantaran', '>=', now()->subDays(7))
        ->orderBy('tanggal_pengantaran', 'desc')
        ->get();

    return view('admin.histori', compact('histori'));
}



}
