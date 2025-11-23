<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Store;
use App\Models\SisaRoti;
use App\Models\StokRoti;
use Carbon\Carbon;

class SalesSisaController extends Controller
{
    /** 📄 Form Input Sisa */
    public function create()
    {
        $stores = Store::where('sales_id', Auth::id())->get();

        $columns = Schema::getColumnListing('stok_rotis');
        $variants = [];

        foreach ($columns as $col) {
            if (str_contains($col, '_masuk')) {
                $variants[] = str_replace('_masuk', '', $col);
            }
        }

        return view('sales.input_sisa', compact('stores', 'variants'));
    }

    /** 💾 Simpan Input Sisa */
    public function store(Request $request)
    {
        $columns = Schema::getColumnListing('stok_rotis');
        $variants = [];

        foreach ($columns as $col) {
            if (str_contains($col, '_masuk')) {
                $variants[] = str_replace('_masuk', '', $col);
            }
        }

        $rules = [
            'nama_toko' => 'required|string|max:255',
            'tanggal_pengambilan' => 'required|date',
            'foto_sisa' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];

        foreach ($variants as $v) {
            $rules[$v . '_sisa'] = 'required|integer|min:0';
        }

        $request->validate($rules);

        $tanggalAmbil = Carbon::parse($request->tanggal_pengambilan)->format('Y-m-d');

        $stok = StokRoti::where('user_id', Auth::id())
            ->where('nama_toko', $request->nama_toko)
            ->whereDate('tanggal_pengantaran', '<', $tanggalAmbil)
            ->orderBy('tanggal_pengantaran', 'desc')
            ->first();

        if (!$stok) {
            return back()->with('error',
                "⚠ Tidak ditemukan data stok sebelumnya untuk toko ini! Harap input stok masuk dulu."
            )->withInput();
        }

        if (SisaRoti::where('stok_roti_id', $stok->id)->exists()) {
            return back()->with('error',
                "⚠ Sisa roti untuk stok ini sudah pernah diinput sebelumnya!"
            )->withInput();
        }

        $fotoSisaPath = $request->hasFile('foto_sisa')
            ? $request->file('foto_sisa')->store('foto_sisa', 'public')
            : null;

        $data = [
            'user_id' => Auth::id(),
            'nama_toko' => $request->nama_toko,
            'stok_roti_id' => $stok->id,
            'tanggal_pengambilan' => $tanggalAmbil,
            'foto_sisa' => $fotoSisaPath,
        ];

        $hargaSatuan = 1700;
        $totalBill = 0;

        foreach ($variants as $v) {
            $stokMasuk = $stok->{$v . '_masuk'} ?? 0;
            $stokSisa = $request->input($v . '_sisa', 0);

            if ($stokSisa > $stokMasuk) {
                $label = ucfirst(str_replace('_', ' ', $v));
                return back()->with('error',
                    "⚠ Sisa $label tidak boleh melebihi stok masuk ($stokMasuk)!"
                )->withInput();
            }

            $terjual = max($stokMasuk - $stokSisa, 0);

            $data[$v . '_sisa'] = $stokSisa;
            $data[$v . '_terjual'] = $terjual;

            $totalBill += $terjual * $hargaSatuan;
        }

        $data['total_bill'] = $totalBill;

        SisaRoti::create($data);

        $msg = $totalBill > 0
            ? "Data sisa berhasil disimpan! Total tagihan: Rp " . number_format($totalBill, 0, ',', '.')
            : "Data sisa berhasil disimpan! Tidak ada roti terjual.";

        return redirect()->route('sales.home')->with('success', $msg);

        // ================================
        // UPDATE TARGET SALES OTOMATIS
        // ================================
        $bulan = now()->format('Y-m');

        $target = \App\Models\SalesTarget::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'bulan'   => $bulan,
            ],
            [
                'target_bulanan' => 0,
                'tercapai'       => 0
            ]
        );

        // Kurangi target dengan total_bill hari ini
        $target->target_bulanan = max($target->target_bulanan - $sisa->total_bill, 0);

        // Jika sudah mencapai target
        if ($target->target_bulanan <= 0) {
            $target->tercapai = 1;
        }

        $target->save();

    }

}
