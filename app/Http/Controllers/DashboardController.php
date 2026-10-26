<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1. Menghitung Total Pendapatan Hari Ini
        $todaySales = DB::table('transactions')
            ->whereDate('created_at', $today)
            ->where('status', 'paid')
            ->sum('total');

        // 2. Menghitung Jumlah Transaksi Hari Ini
        $todayTransactions = DB::table('transactions')
            ->whereDate('created_at', $today)
            ->count();

        // 3. Menghitung Jumlah Bahan Baku yang Menipis
        $lowStockCount = DB::table('ingredients')
            ->whereRaw('stock <= min_stock')
            ->count();

        // 4. Mengambil 5 Menu Terlaris (Berdasarkan jumlah terjual)
        $topMenus = DB::table('transaction_items')
            ->select('menu_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('menu_name')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('todaySales', 'todayTransactions', 'lowStockCount', 'topMenus'));
    }
}