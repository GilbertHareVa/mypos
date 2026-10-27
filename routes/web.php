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
    // Halaman Data Menu
    Route::get('/admin/menus', [\App\Http\Controllers\MenuController::class, 'index'])->name('menus.index');
    Route::get('/admin/menus/create', [\App\Http\Controllers\MenuController::class, 'create'])->name('menus.create');
    Route::post('/admin/menus', [\App\Http\Controllers\MenuController::class, 'store'])->name('menus.store');
    // Halaman Data Menu
    Route::get('/admin/menus', [\App\Http\Controllers\MenuController::class, 'index'])->name('menus.index');
    Route::get('/admin/menus/create', [\App\Http\Controllers\MenuController::class, 'create'])->name('menus.create');
    Route::post('/admin/menus', [\App\Http\Controllers\MenuController::class, 'store'])->name('menus.store');
    // Fitur Edit & Hapus Menu
    Route::get('/admin/menus/{id}/edit', [\App\Http\Controllers\MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/admin/menus/{id}', [\App\Http\Controllers\MenuController::class, 'update'])->name('menus.update');
    Route::delete('/admin/menus/{id}', [\App\Http\Controllers\MenuController::class, 'destroy'])->name('menus.destroy');
    // Halaman Data Karyawan (Users)
    Route::get('/admin/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    // Halaman Data Bahan Baku (Inventory)
    Route::get('/admin/ingredients', [\App\Http\Controllers\IngredientController::class, 'index'])->name('ingredients.index');
    // Halaman POS Kasir
Route::get('/pos', [\App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
// Halaman POS Kasir
    Route::get('/pos', [\App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/transaction/start', [\App\Http\Controllers\PosController::class, 'startTransaction']);
    // Halaman Pengaturan Cafe & Printer
    Route::get('/admin/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::post('/admin/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
    
});