<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Rute untuk halaman utama (sementara kita buat teks sederhana dulu)
Route::get('/', function () {
    $setting = \Illuminate\Support\Facades\DB::table('settings')->first();
    $menus = \Illuminate\Support\Facades\DB::table('menus')->get();
    return view('welcome', compact('setting', 'menus'));
});

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
    // Halaman Laporan Penjualan
    Route::get('/admin/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    // Halaman Data Menu
    Route::get('/admin/menus', [\App\Http\Controllers\MenuController::class, 'index'])->name('menus.index');
    // Halaman Data Menu
    Route::get('/admin/menus', [\App\Http\Controllers\MenuController::class, 'index'])->name('menus.index');
    Route::get('/admin/menus/create', [\App\Http\Controllers\MenuController::class, 'create'])->name('menus.create');
    Route::post('/admin/menus', [\App\Http\Controllers\MenuController::class, 'store'])->name('menus.store');
    // Halaman Data Menu
    Route::get('/admin/menus', [\App\Http\Controllers\MenuController::class, 'index'])->name('menus.index');
    Route::post('/admin/menus', [\App\Http\Controllers\MenuController::class, 'store'])->name('menus.store');
    Route::delete('/admin/menus/{id}', [\App\Http\Controllers\MenuController::class, 'destroy'])->name('menus.destroy');
    // Fitur Edit & Hapus Menu
    Route::get('/admin/menus/{id}/edit', [\App\Http\Controllers\MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/admin/menus/{id}', [\App\Http\Controllers\MenuController::class, 'update'])->name('menus.update');
    Route::delete('/admin/menus/{id}', [\App\Http\Controllers\MenuController::class, 'destroy'])->name('menus.destroy');
    // Halaman Data Karyawan (Users)
    Route::get('/admin/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    // Halaman Data Karyawan (Users)
    Route::get('/admin/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('/admin/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('/admin/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::delete('/admin/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    // Halaman Data Bahan Baku (Inventory)
    Route::get('/admin/ingredients', [\App\Http\Controllers\IngredientController::class, 'index'])->name('ingredients.index');
    // Halaman Data Bahan Baku (Inventory)
    Route::get('/admin/ingredients', [\App\Http\Controllers\IngredientController::class, 'index'])->name('ingredients.index');
    Route::get('/admin/ingredients/create', [\App\Http\Controllers\IngredientController::class, 'create'])->name('ingredients.create');
    Route::post('/admin/ingredients', [\App\Http\Controllers\IngredientController::class, 'store'])->name('ingredients.store');
    Route::delete('/admin/ingredients/{id}', [\App\Http\Controllers\IngredientController::class, 'destroy'])->name('ingredients.destroy');
    // Halaman POS Kasir
    Route::get('/pos', [\App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
    Route::get('/pos/history', [\App\Http\Controllers\PosController::class, 'history'])->name('pos.history');
// Halaman POS Kasir
    Route::get('/pos', [\App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/transaction/start', [\App\Http\Controllers\PosController::class, 'startTransaction']);
    Route::post('/pos/transaction/start', [\App\Http\Controllers\PosController::class, 'startTransaction']);
    Route::get('/pos/receipt/{invoice}', [\App\Http\Controllers\PosController::class, 'receipt'])->name('pos.receipt');
// Halaman Pengaturan Cafe & Printer
    Route::get('/admin/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::post('/admin/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
    
});