<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Rute untuk halaman utama (sementara kita buat teks sederhana dulu)
Route::get('/', [\App\Http\Controllers\LandingController::class, 'index']);

// Rute untuk Halaman Login
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
// Rute yang wajib Login (Hanya bisa diakses setelah login)
Route::middleware(['auth'])->group(function () {
    
    // Halaman Dashboard Admin
   // Halaman Dashboard Admin
Route::get('/admin/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');
// Halaman Data Transaksi
    Route::get('/admin/transactions', [\App\Http\Controllers\TransactionController::class, 'index'])->name('transactions.index');
    // Halaman Data Menu
    Route::get('/admin/menus', [\App\Http\Controllers\MenuController::class, 'index'])->name('menus.index');
    // Halaman POS Kasir
Route::get('/pos', [\App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
// Halaman POS Kasir
    Route::get('/pos', [\App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/transaction/start', [\App\Http\Controllers\PosController::class, 'startTransaction']);
    
});