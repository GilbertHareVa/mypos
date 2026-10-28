<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Penjualan Hari Ini - SeashellKitchen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#fcfbf9] text-gray-800 antialiased min-h-screen flex flex-col">

    <!-- Top Navigation -->
    <nav class="bg-white border-b border-gray-200/80 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <a href="/pos" class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-2 rounded-xl transition flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="font-extrabold text-lg text-[#2c1810]">Riwayat Penjualan Hari Ini</h1>
        </div>
        <a href="/pos" class="bg-[#2c1810] hover:bg-[#3d2319] text-white px-4 py-2 rounded-xl font-bold text-xs transition">
            Kembali ke Kasir
        </a>
    </nav>

    <!-- Main Content -->
    <main class="max-w-5xl w-full mx-auto p-6 flex-1">
        
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-2xs">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Transaksi Hari Ini</p>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1">{{ $transactions->count() }} Transaksi</h3>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-2xs">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Omzet Hari Ini</p>
                <h3 class="text-2xl font-extrabold text-[#2c1810] mt-1">
                    Rp {{ number_format($transactions->sum(fn($t) => data_get($t, 'total_amount') ?? data_get($t, 'total') ?? 0), 0, ',', '.') }}
                </h3>
            </div>
        </div>

        <!-- Table Transaksi -->
        <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs overflow-hidden">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100 text-gray-400 font-bold uppercase text-xs tracking-wider">
                        <th class="p-4 pl-6">No. Invoice</th>
                        <th class="p-4">Waktu</th>
                        <th class="p-4">Total Bayar</th>
                        <th class="p-4 pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $trx)
                        @php
                            $totalVal = data_get($trx, 'total_amount') ?? data_get($trx, 'total') ?? 0;
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 pl-6 font-extrabold text-gray-900">{{ $trx->invoice_number }}</td>
                            <td class="p-4 text-gray-500 font-medium">{{ date('H:i', strtotime($trx->created_at)) }} WIB</td>
                            <td class="p-4 font-bold text-[#2c1810]">Rp {{ number_format($totalVal, 0, ',', '.') }}</td>
                            <td class="p-4 pr-6 text-right">
                                <a href="/pos/receipt/{{ $trx->invoice_number }}" target="_blank" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-bold transition inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    Cetak Struk
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-400 font-medium">Belum ada transaksi yang dilakukan hari ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>

</body>
</html>