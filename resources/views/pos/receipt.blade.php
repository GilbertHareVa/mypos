<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk - {{ $transaction->invoice_number }}</title>
    <style>
        /* CSS Khusus Printer Thermal (Kertas Kecil) */
        body { font-family: 'Courier New', Courier, monospace; width: 300px; margin: 0 auto; color: #000; font-size: 14px; background: #fff; padding: 20px; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .border-dashed { border-bottom: 1px dashed #000; margin: 10px 0; }
        .flex-between { display: flex; justify-content: space-between; }
        .mb-1 { margin-bottom: 4px; }
        .mt-2 { margin-top: 8px; }
        
        /* Hilangkan elemen yang tidak perlu saat di-print fisik */
        @media print {
            @page { margin: 0; }
            body { margin: 10px; width: 100%; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()"> <!-- Script otomatis membuka layar Print -->
    
    <div class="text-center font-bold" style="font-size: 18px;">{{ $settings['cafe_name'] ?? 'SeashellKitchen Cafe' }}</div>
    <div class="text-center" style="font-size: 12px;">{{ $settings['cafe_address'] ?? '' }}</div>
    <div class="text-center" style="font-size: 12px;">Telp: {{ $settings['cafe_phone'] ?? '' }}</div>
    
    <div class="border-dashed"></div>
    
    <div class="flex-between mb-1" style="font-size: 12px;">
        <span>{{ $transaction->invoice_number }}</span>
        <span>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i') }}</span>
    </div>
    <div style="font-size: 12px;">Kasir: {{ $transaction->kasir_name }}</div>
    
    <div class="border-dashed"></div>

    <!-- Daftar Pesanan -->
    @foreach($items as $item)
    <div class="mb-1">
        <div>{{ $item->menu_name }}</div>
        <div class="flex-between">
            <span>{{ $item->quantity }} x {{ number_format($item->price, 0, ',', '.') }}</span>
            <span>{{ number_format($item->subtotal, 0, ',', '.') }}</span>
        </div>
    </div>
    @endforeach

    <div class="border-dashed"></div>

    <!-- Ringkasan Harga -->
    <div class="flex-between mb-1 font-bold">
        <span>Subtotal:</span>
        <span>{{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
    </div>
    <div class="flex-between mb-1 font-bold">
        <span>Pajak ({{ $settings['tax_percentage'] ?? 10 }}%):</span>
        <span>{{ number_format($transaction->tax, 0, ',', '.') }}</span>
    </div>
    <div class="flex-between mb-1 font-bold" style="font-size: 16px;">
        <span>Total:</span>
        <span>{{ number_format($transaction->total, 0, ',', '.') }}</span>
    </div>
    
    <div class="border-dashed"></div>
    
    <!-- Pembayaran -->
    <div class="flex-between mb-1">
        <span>Tunai:</span>
        <span>{{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
    </div>
    <div class="flex-between mb-1">
        <span>Kembali:</span>
        <span>{{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
    </div>

    <div class="border-dashed mt-2"></div>
    
    <!-- Pesan Penutup -->
    <div class="text-center font-bold mt-2" style="font-size: 12px;">{{ $settings['cafe_tagline'] ?? 'Terima Kasih!' }}</div>
    
    <button class="no-print" onclick="window.print()" style="margin-top: 20px; width: 100%; padding: 10px; cursor: pointer; background: #5c3d1e; color: white; border: none; font-weight: bold; border-radius: 5px;">Cetak Ulang</button>
</body>
</html>