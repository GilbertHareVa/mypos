<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $transaction->invoice_number }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            width: 58mm;
            margin: 0 auto;
            padding: 8px;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .border-dashed { border-bottom: 1px dashed #000; margin: 6px 0; }
        .flex { display: flex; justify-content: space-between; }
        @media print {
            body { width: 100%; padding: 0; }
            @page { margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Header Struk -->
    <div class="text-center">
        <h3 style="margin: 0; font-size: 15px;" class="font-bold">{{ $setting->store_name ?? 'SeashellKitchen' }}</h3>
        <p style="margin: 2px 0;">{{ $setting->address ?? '' }}</p>
        @if(!empty($setting->phone))
            <p style="margin: 2px 0;">Telp/WA: {{ $setting->phone }}</p>
        @endif
    </div>

    <div class="border-dashed"></div>

    <!-- Info Transaksi -->
    <div>
        <p style="margin: 2px 0;">No : {{ $transaction->invoice_number }}</p>
        <p style="margin: 2px 0;">Tgl: {{ date('d/m/Y H:i', strtotime($transaction->created_at ?? now())) }}</p>
    </div>

    <div class="border-dashed"></div>

   <!-- Item Pesanan -->
    <div style="margin-bottom: 4px;">
        @foreach($items as $item)
            <div style="margin-bottom: 4px;">
                <div>{{ data_get($item, 'item_name') ?? data_get($item, 'menu_name') ?? data_get($item, 'name') ?? 'Menu' }}</div>
                <div class="flex">
                    <span>{{ $item->quantity }} x {{ number_format($item->price, 0, ',', '.') }}</span>
                    <span>{{ number_format(data_get($item, 'subtotal', $item->quantity * $item->price), 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="border-dashed"></div>

    <!-- Rincian Pembayaran -->
    <div class="flex font-bold" style="font-size: 13px;">
        <span>TOTAL</span>
        <span>Rp {{ number_format($transaction->total_amount ?? $transaction->total, 0, ',', '.') }}</span>
    </div>

    @if(isset($transaction->pay_amount) && $transaction->pay_amount > 0)
        <div class="flex" style="margin-top: 2px;">
            <span>Bayar</span>
            <span>Rp {{ number_format($transaction->pay_amount, 0, ',', '.') }}</span>
        </div>
        <div class="flex">
            <span>Kembali</span>
            <span>Rp {{ number_format($transaction->change_amount ?? ($transaction->pay_amount - ($transaction->total_amount ?? $transaction->total)), 0, ',', '.') }}</span>
        </div>
    @endif

    <div class="border-dashed"></div>

    <!-- Footer Struk -->
    <div class="text-center" style="margin-top: 10px;">
        <p style="margin: 0; font-style: italic;">{{ $setting->receipt_footer ?? 'Terima kasih atas kunjungan Anda!' }}</p>
    </div>

</body>
</html>