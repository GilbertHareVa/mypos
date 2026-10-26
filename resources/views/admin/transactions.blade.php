@extends('layouts.admin')

@section('title', 'Data Transaksi Penjualan')

@section('content')
<div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm">
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-[#fdf8f0] text-gray-700 font-bold border-b border-[#f5deb3]">
                <tr>
                    <th class="py-3 px-4">No. Invoice</th>
                    <th class="py-3 px-4">Waktu</th>
                    <th class="py-3 px-4">Kasir</th>
                    <th class="py-3 px-4">Metode</th>
                    <th class="py-3 px-4">Total Belanja</th>
                    <th class="py-3 px-4">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-3 px-4 font-bold text-[#5c3d1e]">{{ $trx->invoice_number }}</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y, H:i') }}</td>
                    <td class="py-3 px-4">{{ $trx->kasir_name }}</td>
                    <td class="py-3 px-4 uppercase">{{ $trx->payment_method }}</td>
                    <td class="py-3 px-4 font-bold text-gray-800">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                    <td class="py-3 px-4">
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded font-bold text-xs uppercase">{{ $trx->status }}</span>
                    </td>
                </tr>
                @endforeach
                
                @if($transactions->isEmpty())
                <tr>
                    <td colspan="6" class="py-6 text-center text-gray-500">Belum ada transaksi hari ini.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>
@endsection