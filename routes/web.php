<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SalesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Halaman awal
Route::get('/', function () {
    return view('welcome');
});

// 🔐 Login & Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 👑 Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/home', function () {
        return view('admin.home');
    })->name('admin.home');
});

// 🧾 Sales routes
Route::middleware(['auth', 'role:sales'])->group(function () {
    Route::get('/sales/home', [SalesController::class, 'home'])->name('sales.home');
    Route::get('/sales/input-stok', [SalesController::class, 'create'])->name('sales.input');
    Route::post('/sales/input-stok', [SalesController::class, 'store'])->name('sales.store');

    Route::get('/sales/histori', [SalesController::class, 'histori'])->name('sales.histori');
    Route::get('/sales/lokasi', [SalesController::class, 'lokasi'])->name('sales.lokasi'); 
    Route::get('/sales/daftartoko', [SalesController::class, 'daftarToko'])->name('sales.daftartoko');
    Route::get('/sales/tambah', [SalesController::class, 'tambahToko'])->name('sales.tambahtoko');

    // Tambahan untuk update lokasi toko
    Route::post('/sales/update-lokasi/{id}', [SalesController::class, 'updateLokasi'])->name('sales.updateLokasi');
});
