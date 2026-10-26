<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        // Mengambil data transaksi dari database, digabung dengan nama kasir
        $transactions = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('transactions.*', 'users.name as kasir_name')
            ->orderBy('transactions.created_at', 'desc')
            ->get();

        return view('admin.transactions', compact('transactions'));
    }
}