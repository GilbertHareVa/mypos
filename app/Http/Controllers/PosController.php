<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PosController extends Controller
{
    public function index()
    {
        $menus = DB::table('menus')->where('is_available', true)->get();
        return view('pos.index', compact('menus'));
    }

    public function startTransaction(Request $request)
    {
        $cart = $request->input('cart');
        $paidAmount = $request->input('paid_amount');
        
        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong']);
        }

        // Hitung Total
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }
        $tax = $subtotal * 0.10;
        $grandTotal = $subtotal + $tax;
        $changeAmount = $paidAmount - $grandTotal;

        // Generate Nomor Invoice (Contoh: INV-20261026-0001)
        $datePrefix = Carbon::now()->format('Ymd');
        $lastTx = DB::table('transactions')->whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->first();
        $sequence = $lastTx ? intval(substr($lastTx->invoice_number, -4)) + 1 : 1;
        $invoiceNumber = 'INV-' . $datePrefix . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        // Simpan ke tabel Transaksi
        $transactionId = DB::table('transactions')->insertGetId([
            'invoice_number' => $invoiceNumber,
            'user_id' => auth()->id(),
            'order_type' => 'dine_in',
            'status' => 'paid',
            'payment_method' => 'cash',
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => 0,
            'total' => $grandTotal,
            'paid_amount' => $paidAmount,
            'change_amount' => $changeAmount,
            'paid_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Simpan setiap item menu yang dibeli ke tabel Item
        $items = [];
        foreach ($cart as $item) {
            $items[] = [
                'transaction_id' => $transactionId,
                'menu_id' => $item['id'],
                'menu_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['qty'],
                'subtotal' => $item['price'] * $item['qty'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('transaction_items')->insert($items);

        return response()->json([
            'success' => true,
            'invoice' => $invoiceNumber,
            'change' => $changeAmount
        ]);
    }
public function receipt($invoice)
    {
        // 1. Ambil data transaksi beserta nama kasirnya
        $transaction = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('transactions.*', 'users.name as kasir_name')
            ->where('invoice_number', $invoice)
            ->first();

        if (!$transaction) {
            return abort(404, 'Transaksi tidak ditemukan');
        }

        // 2. Ambil daftar menu yang dibeli di transaksi ini
        $items = DB::table('transaction_items')->where('transaction_id', $transaction->id)->get();
        
        // 3. Ambil pengaturan cafe (Nama, Alamat, Footer Struk)
        $setting = DB::table('settings')->first();

        return view('pos.receipt', compact('transaction', 'items', 'setting'));

return view('pos.receipt', compact('transaction', 'items', 'setting'));
    } // <-- Tambahkan tanda kurung kurawal ini untuk menutup fungsi sebelumnya

    public function history()
    {
        // Mengambil transaksi yang dibuat HARI INI saja
        $transactions = \Illuminate\Support\Facades\DB::table('transactions')
            ->whereDate('created_at', \Carbon\Carbon::today())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pos.history', compact('transactions'));
    }
}   