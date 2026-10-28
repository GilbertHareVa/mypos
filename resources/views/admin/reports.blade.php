@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="space-y-6">

    <!-- Kotak Filter Tanggal -->
    <div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Filter Rentang Waktu</h3>
        <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-1/3">
                <label class="block text-sm font-bold text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none">
            </div>
            <div class="w-full md:w-1/3">
                <label class="block text-sm font-bold text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none">
            </div>
            <div class="w-full md:w-auto">
                <button type="submit" class="w-full bg-[#5c3d1e] text-white px-8 py-3 rounded-lg font-bold hover:bg-[#4a3118] transition shadow-md">Tampilkan Laporan</button>
            </div>
        </form>
    </div>

    <!-- Kotak Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-r from-green-600 to-green-500 p-6 rounded-xl text-white shadow-md flex justify-between items-center">
            <div>
                <p class="text-green-100 font-medium mb-1">Total Pendapatan Periode Ini</p>
                <h3 class="text-4xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>
        <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-6 rounded-xl text-white shadow-md flex justify-between items-center">
            <div>
                <p class="text-blue-100 font-medium mb-1">Total Transaksi Sukses</p>
                <h3 class="text-4xl font-bold">{{ $totalOrders }} <span class="text-xl">Order</span></h3>
            </div>
        </div>
    </div>

    <!-- Tabel Rincian -->
    <div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Rincian Transaksi</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#fdf8f0] text-gray-700 font-bold border-b border-[#f5deb3]">
                    <tr>
                        <th class="py-3 px-4">No. Invoice</th>
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4">Kasir</th>
                        <th class="py-3 px-4 text-right">Subtotal</th>
                        <th class="py-3 px-4 text-right">Pajak</th>
                        <th class="py-3 px-4 text-right">Total Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $trx)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4 font-bold text-[#5c3d1e]">{{ $trx->invoice_number }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y, H:i') }}</td>
                        <td class="py-3 px-4">{{ $trx->kasir_name }}</td>
                        <td class="py-3 px-4 text-right text-gray-600">Rp {{ number_format($trx->subtotal, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-right text-gray-600">Rp {{ number_format($trx->tax, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-right font-bold text-green-600">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    
                    @if($transactions->isEmpty())
                    <tr>
                        <td colspan="6" class="py-6 text-center text-gray-500">Tidak ada transaksi pada rentang tanggal ini.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection