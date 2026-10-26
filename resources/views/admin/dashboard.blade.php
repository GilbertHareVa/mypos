@extends('layouts.admin')

@section('title', 'Dashboard Hari Ini')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Kotak Statistik -->
        <div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm">
            <p class="text-sm text-gray-500 font-medium mb-1">Total Penjualan</p>
            <h3 class="text-2xl font-bold text-[#5c3d1e]">Rp 1.250.000</h3>
        </div>
        <div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm">
            <p class="text-sm text-gray-500 font-medium mb-1">Jumlah Transaksi</p>
            <h3 class="text-2xl font-bold text-[#5c3d1e]">42 Order</h3>
        </div>
        <div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm">
            <p class="text-sm text-gray-500 font-medium mb-1">Open Order (Belum Bayar)</p>
            <h3 class="text-2xl font-bold text-orange-500">3 Meja</h3>
        </div>
        <div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm">
            <p class="text-sm text-gray-500 font-medium mb-1">Stok Bahan Menipis</p>
            <h3 class="text-2xl font-bold text-red-500">5 Item</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Area Grafik Penjualan & Top Menu (Segera Hadir)</h3>
        <p class="text-gray-500 text-sm">Bagian ini akan kita isi dengan grafik dan tabel menu terlaris dari database nanti.</p>
    </div>
@endsection