<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StoreController;

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
    Route::get('/sales/histori', [SalesController::class, 'histori'])->name('sales.histori');
    Route::get('/sales/lokasi', [SalesController::class, 'lokasi'])->name('sales.lokasi');
    Route::get('/sales/input-stok', [SalesController::class, 'create'])->name('sales.input');
    Route::post('/sales/input-stok', [SalesController::class, 'storeStok'])->name('sales.stok.store');

    // CRUD TOKO
    Route::get('/sales/daftartoko', [StoreController::class, 'index'])->name('sales.daftartoko');
    Route::get('/sales/tambah', [StoreController::class, 'create'])->name('sales.tambahtoko');
    Route::post('/sales/tambah', [StoreController::class, 'store'])->name('sales.store');
    Route::delete('/sales/toko/{id}', [StoreController::class, 'destroy'])->name('sales.toko.destroy');
});
