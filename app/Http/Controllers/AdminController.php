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
        $totalHariIni = \App\Models\SisaRoti::whereDate('tanggal_pengambilan', today())
            ->sum('total_bill');

        $totalBulanIni = \App\Models\SisaRoti::whereYear('tanggal_pengambilan', now()->year)
            ->whereMonth('tanggal_pengambilan', now()->month)
            ->sum('total_bill');

        $jumlahSales = \App\Models\User::where('role', 'sales')->count();
        $jumlahToko = \App\Models\Store::count();

        $tanggal = [];
        $penjualan = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->format('Y-m-d');
            $tanggal[] = now()->subDays($i)->format('d M');

            $penjualan[] = \App\Models\SisaRoti::whereDate('tanggal_pengambilan', $day)
                ->sum('total_bill');
        }

        $topSales = \App\Models\SisaRoti::select('user_id')
            ->selectRaw('SUM(total_bill) as total')
            ->where('tanggal_pengambilan', '>=', now()->subDays(7))
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->with('user')
            ->take(3)
            ->get();

        $aktivitas = \App\Models\SisaRoti::latest()->take(5)->get();

        $bulan = now()->format('Y-m');

        $targetSales = \App\Models\SalesTarget::where('bulan', $bulan)
            ->with('user')
            ->get();

        return view('admin.home', compact(
            'totalHariIni',
            'totalBulanIni',
            'jumlahSales',
            'jumlahToko',
            'tanggal',
            'penjualan',
            'topSales',
            'aktivitas',
            'targetSales'
        ));
    }


    public function sales()
    {
        $sales = User::where('role', 'sales')->latest()->get();
        return view('admin.sales', compact('sales'));
    }

    public function tambahSales(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|string|min:5',
            'phone'    => 'required|string|max:20',
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

    public function updateSales(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:100',
            'phone'    => 'required|string|max:20',
            'password' => 'nullable|string|min:5',
        ]);

        $sales = User::findOrFail($id);

        $sales->name     = $request->name;
        $sales->username = $request->username;
        $sales->phone    = $request->phone;

        // Update password hanya jika diisi
        if ($request->password) {
            $sales->password = Hash::make($request->password);
        }

        $sales->save();

        return redirect()->route('admin.sales')->with('success', 'Akun sales berhasil diperbarui.');
    }

    public function hapusSales($id)
    {
        $sales = User::findOrFail($id);

        if (Auth::id() === $sales->id) {
            return back()->with('error', 'Tidak bisa menghapus akun kamu sendiri.');
        }

        $sales->delete();

        return redirect()->route('admin.sales')->with('success', 'Akun sales berhasil dihapus.');
    }

    public function daftarToko()
    {
        $stores = Store::latest()->get();
        return view('admin.daftar_toko', compact('stores'));
    }

    public function updateToko(Request $request, $id)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
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

    public function lokasiToko()
    {
        $stores = Store::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['name', 'address', 'latitude', 'longitude']);

        return view('admin.lokasi_toko', compact('stores'));
    }

    public function histori(Request $request)
    {
        $toko = $request->toko;
        $filter = $request->filter ?? 'semua';

        $historiMasuk = \App\Models\StokRoti::query()->with('user');
        $historiPenjualan = \App\Models\SisaRoti::query()->with('user');

        if ($toko) {
            $historiMasuk->where('nama_toko', 'like', "%$toko%");
            $historiPenjualan->where('nama_toko', 'like', "%$toko%");
        }

        if ($filter == 'hari') {
            $historiMasuk->whereDate('tanggal_pengantaran', today());
            $historiPenjualan->whereDate('tanggal_pengambilan', today());
        } elseif ($filter == 'minggu') {
            $historiMasuk->where('tanggal_pengantaran', '>=', now()->subDays(7));
            $historiPenjualan->where('tanggal_pengambilan', '>=', now()->subDays(7));
        } elseif ($filter == 'bulan') {
            $historiMasuk->where('tanggal_pengantaran', '>=', now()->subDays(30));
            $historiPenjualan->where('tanggal_pengambilan', '>=', now()->subDays(30));
        }

        return view('admin.histori', [
            'historiMasuk'     => $historiMasuk->orderBy('tanggal_pengantaran', 'desc')->get(),
            'historiPenjualan' => $historiPenjualan->orderBy('tanggal_pengambilan', 'desc')->get(),
            'filter'           => $filter,
            'toko'             => $toko,
        ]);
    }

    public function statistik(Request $request)
    {
        $toko = $request->toko;
        $filter = $request->filter ?? 'minggu';

        $stok = \App\Models\StokRoti::query();
        $penjualan = \App\Models\SisaRoti::query();

        if ($toko) {
            $stok->where('nama_toko', 'like', "%$toko%");
            $penjualan->where('nama_toko', 'like', "%$toko%");
        }

        if ($filter == 'hari') {
            $stok->whereDate('tanggal_pengantaran', today());
            $penjualan->whereDate('tanggal_pengambilan', today());
        } elseif ($filter == 'minggu') {
            $stok->where('tanggal_pengantaran', '>=', now()->subDays(7));
            $penjualan->where('tanggal_pengambilan', '>=', now()->subDays(7));
        } elseif ($filter == 'bulan') {
            $stok->where('tanggal_pengantaran', '>=', now()->subDays(30));
            $penjualan->where('tanggal_pengambilan', '>=', now()->subDays(30));
        }

        $stok = $stok->get();
        $penjualan = $penjualan->get();

        $rasaData = [];
        foreach ($penjualan as $item) {
            foreach ($item->getAttributes() as $key => $value) {
                if (str_contains($key, '_terjual')) {
                    $rasa = str_replace('_terjual', '', $key);
                    $rasaData[$rasa] = ($rasaData[$rasa] ?? 0) + intval($value);
                }
            }
        }

        $filterSales = $request->filter_sales ?? 'minggu';

        $perfQuery = \App\Models\SisaRoti::query()->with('user');

        if ($filterSales == 'hari') {
            $perfQuery->whereDate('tanggal_pengambilan', today());
        } elseif ($filterSales == 'minggu') {
            $perfQuery->where('tanggal_pengambilan', '>=', now()->subDays(7));
        } elseif ($filterSales == 'bulan') {
            $perfQuery->where('tanggal_pengambilan', '>=', now()->subDays(30));
        }

        $perfData = $perfQuery->get();

        $salesPerformance = [];

        foreach ($perfData as $item) {
            if (!$item->user) continue;

            $salesName = $item->user->name;

            if (!isset($salesPerformance[$salesName])) {
                $salesPerformance[$salesName] = [
                    'total_terjual' => 0,
                    'total_uang' => 0,
                ];
            }

            foreach ($item->getAttributes() as $key => $value) {
                if (str_contains($key, '_terjual')) {
                    $salesPerformance[$salesName]['total_terjual'] += intval($value);
                }
            }

            $salesPerformance[$salesName]['total_uang'] += $item->total_bill;
        }

        return view('admin.statistik', [
            'rasaData' => $rasaData,
            'salesPerformance' => $salesPerformance,
            'filter' => $filter,
            'filterSales' => $filterSales,
            'toko' => $toko,
        ]);
    }

    public function target(Request $request)
    {
        $bulan = $request->bulan ?? now()->format('Y-m');

        $sales = \App\Models\User::where('role', 'sales')->get();

        $salesData = [];

        foreach ($sales as $s) {
            $target = \App\Models\SalesTarget::firstOrCreate(
                [
                    'user_id' => $s->id,
                    'bulan'   => $bulan
                ],
                [
                    'target_bulanan' => 0,
                    'tercapai'       => 0
                ]
            );

            $totalPenjualan = \App\Models\SisaRoti::where('user_id', $s->id)
                ->whereYear('tanggal_pengambilan', substr($bulan, 0, 4))
                ->whereMonth('tanggal_pengambilan', substr($bulan, 5, 2))
                ->sum('total_bill');

            $target->tercapai = $totalPenjualan;

            $salesData[] = [
                'sales'  => $s,
                'target' => $target
            ];
        }

        return view('admin.target', compact('salesData', 'bulan'));
    }

    public function updateTarget(Request $request)
    {
        $request->validate([
            'user_id'        => 'required|integer',
            'bulan'          => 'required|date_format:Y-m',
            'target_bulanan' => 'required|integer|min:0'
        ]);

        \App\Models\SalesTarget::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'bulan'   => $request->bulan
            ],
            [
                'target_bulanan' => $request->target_bulanan
            ]
        );

        return back()->with('success', 'Target berhasil diperbarui!');
    }

}
