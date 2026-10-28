@extends('layouts.admin')

@section('title', 'Dashboard Hari Ini')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Kotak Statistik 1 -->
        <div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">Pendapatan Hari Ini</p>
                <h3 class="text-3xl font-bold text-[#5c3d1e]">Rp {{ number_format($todaySales, 0, ',', '.') }}</h3>
            </div>
        </div>
        
        <!-- Kotak Statistik 2 -->
        <div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">Transaksi Sukses</p>
                <h3 class="text-3xl font-bold text-[#5c3d1e]">{{ $todayTransactions }} <span class="text-lg">Order</span></h3>
            </div>
        </div>
        
        <!-- Kotak Statistik 3 -->
        <div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">Peringatan Stok Gudang</p>
                @if($lowStockCount > 0)
                    <h3 class="text-3xl font-bold text-red-500">{{ $lowStockCount }} <span class="text-lg">Bahan Menipis!</span></h3>
                @else
                    <h3 class="text-3xl font-bold text-green-500">Aman</h3>
                @endif
            </div>
        </div>
    </div>

    <!-- Area Menu Terlaris -->
    <div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm max-w-2xl">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Menu Terlaris</h3>
        @if($topMenus->isEmpty())
            <p class="text-gray-500 text-sm">Belum ada data penjualan.</p>
        @else
            <ul class="space-y-3">
                @foreach($topMenus as $index => $item)
                <li class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border border-gray-100">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-[#5c3d1e] text-lg">#{{ $index + 1 }}</span>
                        <span class="font-medium text-gray-700">{{ $item->menu_name }}</span>
                    </div>
                    <span class="bg-[#5c3d1e] text-white text-xs font-bold px-3 py-1 rounded-full">{{ $item->total_sold }} Terjual</span>
                </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection