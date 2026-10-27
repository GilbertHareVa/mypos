<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Jika tidak ada input tanggal, gunakan hari ini sebagai default
        $startDate = $request->input('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));

        // Mengambil transaksi hanya pada rentang tanggal yang dipilih
        $transactions = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('transactions.*', 'users.name as kasir_name')
            ->whereBetween(DB::raw('DATE(transactions.created_at)'), [$startDate, $endDate])
            ->where('status', 'paid')
            ->orderBy('transactions.created_at', 'desc')
            ->get();

        // Menghitung ringkasan pendapatan
        $totalRevenue = $transactions->sum('total');
        $totalOrders = $transactions->count();

        return view('admin.reports', compact('transactions', 'totalRevenue', 'totalOrders', 'startDate', 'endDate'));
    }
}