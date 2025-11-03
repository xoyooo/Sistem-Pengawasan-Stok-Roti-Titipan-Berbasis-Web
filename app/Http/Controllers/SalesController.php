// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use App\Models\StokRoti;

// class SalesController extends Controller
// {
//     /** 🏠 Halaman Home */
//     public function home()
//     {
//         return view('sales.home');
//     }

//     /** 🧾 Histori Penjualan */
//     public function histori()
//     {
//         return view('sales.histori');
//     }

//     /** 📍 Lokasi Toko */
//     public function lokasi()
//     {
//         return view('sales.lokasi_toko');
//     }

//     /** 📦 Form Input Stok Roti */
//     // public function create()
//     // {
//     //     return view('sales.input_stok');
//     // }

//     /** 💾 Simpan Stok Roti */
//     public function storeStok(Request $request)
//     {
//         $validated = $request->validate([
//             'toko_id'              => 'required|integer',
//             'jumlah_roti'          => 'required|integer|min:1',
//             'tanggal_pengantaran'  => 'required|date',
//             'foto_roti'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
//         ]);

//         $path = $request->hasFile('foto_roti')
//             ? $request->file('foto_roti')->store('foto_roti', 'public')
//             : null;

//         StokRoti::create([
//             'user_id'             => Auth::id(),
//             'toko_id'             => $validated['toko_id'],
//             'jumlah_roti'         => $validated['jumlah_roti'],
//             'tanggal_pengantaran' => $validated['tanggal_pengantaran'],
//             'foto_roti'           => $path,
//         ]);

//         return redirect()->route('sales.input')->with('success', 'Data stok roti berhasil disimpan!');
//     }
// }
