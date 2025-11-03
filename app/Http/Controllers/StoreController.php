<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function lokasi()
    {
        $stores = Store::all();
        return view('sales.lokasi_toko', compact('stores'));
    }

    public function updateLocation(Request $request, $id)
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

?>