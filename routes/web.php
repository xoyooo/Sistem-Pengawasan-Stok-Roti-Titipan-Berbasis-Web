<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AdminController; // tidak perlu folder "Admin" karena file-nya di root

/*
|--------------------------------------------------------------------------
| Halaman Awal dan Auth
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rute Admin
| Layout: resources/views/layouts/admin.blade.php
| Views : resources/views/admin/...
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Halaman utama
        Route::get('/home', [AdminController::class, 'home'])->name('home');

        // Manajemen Sales
        Route::get('/sales', [AdminController::class, 'sales'])->name('sales');
        Route::post('/sales/tambah', [AdminController::class, 'tambahSales'])->name('sales.tambah');
        Route::delete('/sales/{id}', [AdminController::class, 'hapusSales'])->name('sales.hapus');

        // Daftar toko
        Route::get('/daftar-toko', [AdminController::class, 'daftarToko'])->name('daftartoko');

        // Lokasi toko
        Route::get('/lokasi-toko', [AdminController::class, 'lokasiToko'])->name('lokasitoko');

        // Histori
        Route::get('/histori', [AdminController::class, 'histori'])->name('histori');
    });

/*
|--------------------------------------------------------------------------
| Rute Sales
| Layout: resources/views/layouts/app.blade.php
| Views : resources/views/sales/...
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:sales'])
    ->prefix('sales')
    ->name('sales.')
    ->group(function () {

        Route::get('/home', [SalesController::class, 'home'])->name('home');
        Route::get('/histori', [SalesController::class, 'histori'])->name('histori');
        Route::get('/lokasi', [SalesController::class, 'lokasi'])->name('lokasi');

        // Input stok roti
        Route::get('/input-stok', [SalesController::class, 'create'])->name('input');
        Route::post('/input-stok', [SalesController::class, 'storeStok'])->name('stok.store');

        // CRUD Toko
        Route::get('/daftar-toko', [StoreController::class, 'index'])->name('daftartoko');
        Route::get('/tambah-toko', [StoreController::class, 'create'])->name('tambahtoko');
        Route::post('/tambah-toko', [StoreController::class, 'store'])->name('store');
        Route::delete('/toko/{id}', [StoreController::class, 'destroy'])->name('toko.destroy');
    });
