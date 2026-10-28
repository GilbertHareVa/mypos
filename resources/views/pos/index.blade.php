<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Kasir - {{ $setting->store_name ?? 'SeashellKitchen' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#fcfbf9] text-gray-800 antialiased min-h-screen flex flex-col overflow-x-hidden">

    <!-- Header Navigation -->
    <header class="bg-[#2c1810] text-white sticky top-0 z-40 shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-3 flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="text-xl">🐚</span>
                <div>
                    <h1 class="font-extrabold text-base sm:text-lg leading-none">{{ $setting->store_name ?? 'SeashellKitchen' }} POS</h1>
                    <p class="text-[10px] text-amber-200/80 font-medium">Kasir: {{ auth()->user()->name ?? 'Kasir Utama' }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2 text-xs">
                <a href="/pos/history" class="bg-amber-900/60 hover:bg-amber-900 text-amber-100 px-3 py-1.5 rounded-xl font-bold transition flex items-center gap-1 border border-amber-700/50">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="hidden sm:inline">Riwayat Hari Ini</span>
                    <span class="sm:hidden">Riwayat</span>
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="/admin/dashboard" class="bg-white/10 hover:bg-white/20 text-white px-3 py-1.5 rounded-xl font-bold transition">Dashboard</a>
                @endif

                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500/80 hover:bg-red-600 text-white px-3 py-1.5 rounded-xl font-bold transition">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content Grid -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-3 sm:p-6 grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6">
        
        <!-- Katalog Menu (Kiri di Desktop, Atas di HP) -->
        <section class="lg:col-span-7 xl:col-span-8 order-2 lg:order-1 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="font-extrabold text-gray-900 text-base sm:text-lg">Katalog Menu</h2>
                <span class="text-xs font-semibold text-gray-400">{{ count($menus) }} Menu Tersedia</span>
            </div>

            <!-- Grid Menu -->
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-2.5 sm:gap-4">
                @foreach($menus as $menu)
                    @php
                        $imgUrl = $menu->image;
                        if ($imgUrl && !\Illuminate\Support\Str::startsWith($imgUrl, ['http://', 'https://'])) {
                            $imgUrl = asset('storage/' . $imgUrl);
                        }
                    @endphp
                    <div onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->name) }}', {{ $menu->price }})" 
                         class="bg-white p-3 rounded-2xl border border-gray-200/80 shadow-2xs hover:border-[#2c1810] hover:shadow-md transition active:scale-95 cursor-pointer flex flex-col justify-between">
                        <div>
                            <div class="h-24 sm:h-28 rounded-xl bg-gray-100 overflow-hidden mb-2.5 border border-gray-100">
                                <img src="{{ $imgUrl }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.outerHTML='<div class=\'w-full h-full bg-amber-50 flex items-center justify-center text-2xl\'>🍽️</div>';">
                            </div>
                            <h3 class="font-bold text-gray-900 text-xs sm:text-sm line-clamp-2 leading-snug">{{ $menu->name }}</h3>
                        </div>
                        <p class="font-extrabold text-[#2c1810] text-xs sm:text-sm mt-2">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Keranjang Pesanan (Kanan di Desktop, Sticky/Bawah di HP) -->
        <section class="lg:col-span-5 xl:col-span-4 order-1 lg:order-2">
            <div class="bg-white p-4 sm:p-6 rounded-3xl border border-gray-200/90 shadow-2xs sticky top-20 flex flex-col h-[calc(100vh-100px)] max-h-[650px]">
                
                <div class="pb-3 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-extrabold text-gray-900 text-base">Pesanan Aktif</h2>
                    <button onclick="clearCart()" class="text-xs font-bold text-red-500 hover:text-red-700">Kosongkan</button>
                </div>

                <!-- Daftar Item Keranjang -->
                <div id="cart-items" class="flex-1 overflow-y-auto my-3 space-y-3 pr-1 text-xs sm:text-sm">
                    <p id="empty-cart-msg" class="text-center text-gray-400 py-10">Keranjang masih kosong.<br>Pilih menu dari katalog.</p>
                </div>

                <!-- Total & Tombol Bayar -->
                <div class="pt-3 border-t border-gray-100 space-y-3 bg-white">
                    <div class="flex justify-between text-xs text-gray-500 font-semibold">
                        <span>Pajak (10%)</span>
                        <span id="tax-amount">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-base font-extrabold text-gray-900">
                        <span>Total Tagihan</span>
                        <span id="total-amount" class="text-lg text-[#2c1810]">Rp 0</span>
                    </div>

                    <button onclick="openPaymentModal()" class="w-full bg-[#2c1810] hover:bg-[#3d2319] text-white py-3.5 rounded-2xl font-extrabold text-sm shadow-md transition active:scale-95 flex items-center justify-center gap-2">
                        <span>Proses Pembayaran</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>

            </div>
        </section>

    </main>

    <!-- Modal Pembayaran / Numpad (Responsive Modal) -->
    <div id="payment-modal" class="fixed inset-0 bg-black/60 backdrop-blur-xs hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-sm rounded-3xl shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in zoom-in duration-200">
            <div class="bg-[#2c1810] text-white px-5 py-3.5 font-bold text-sm flex justify-between items-center">
                <span>Pembayaran Kasir</span>
                <button onclick="closePaymentModal()" class="text-gray-300 hover:text-white text-xl font-bold">&times;</button>
            </div>

            <form action="/pos/checkout" method="POST" class="p-5 space-y-4">
                @csrf
                <input type="hidden" name="cart_data" id="cart-data-input">

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Total Tagihan</label>
                    <input type="text" id="modal-total-display" readonly class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 font-extrabold text-lg text-[#2c1810] text-right outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Uang Diterima (Rp)</label>
                    <input type="number" name="pay_amount" id="pay-amount-input" min="0" required placeholder="0" class="w-full border border-gray-200 rounded-xl p-3 font-extrabold text-lg text-right text-gray-900 focus:border-[#2c1810] outline-none">
                </div>

                <!-- Tombol Nominal Cepat -->
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" onclick="setQuickPay(10000)" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold text-xs py-2 rounded-xl">10rb</button>
                    <button type="button" onclick="setQuickPay(20000)" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold text-xs py-2 rounded-xl">20rb</button>
                    <button type="button" onclick="setQuickPay(50000)" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold text-xs py-2 rounded-xl">50rb</button>
                    <button type="button" onclick="setQuickPay(100000)" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold text-xs py-2 rounded-xl col-span-2">100rb</button>
                    <button type="button" onclick="setExactPay()" class="bg-amber-100 hover:bg-amber-200 text-amber-900 font-bold text-xs py-2 rounded-xl">Uang Pas</button>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-[#2c1810] hover:bg-[#3d2319] text-white py-3.5 rounded-2xl font-extrabold text-sm transition shadow-md">
                        Cetak Struk & Selesai
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Pengelolaan Keranjang -->
    <script>
        let cart = [];
        let grandTotal = 0;

        function addToCart(id, name, price) {
            let existing = cart.find(item => item.id === id);
            if (existing) {
                existing.qty += 1;
            } else {
                cart.push({ id: id, name: name, price: price, qty: 1 });
            }
            updateCartUI();
        }

        function updateQty(id, delta) {
            let item = cart.find(i => i.id === id);
            if (item) {
                item.qty += delta;
                if (item.qty <= 0) {
                    cart = cart.filter(i => i.id !== id);
                }
            }
            updateCartUI();
        }

        function clearCart() {
            cart = [];
            updateCartUI();
        }

        function updateCartUI() {
            const container = document.getElementById('cart-items');
            const emptyMsg = document.getElementById('empty-cart-msg');
            
            if (cart.length === 0) {
                container.innerHTML = '<p id="empty-cart-msg" class="text-center text-gray-400 py-10">Keranjang masih kosong.<br>Pilih menu dari katalog.</p>';
                document.getElementById('tax-amount').innerText = 'Rp 0';
                document.getElementById('total-amount').innerText = 'Rp 0';
                grandTotal = 0;
                return;
            }

            let subtotal = 0;
            let html = '';

            cart.forEach(item => {
                let itemTotal = item.price * item.qty;
                subtotal += itemTotal;
                html += `
                    <div class="flex items-center justify-between bg-gray-50 p-2.5 rounded-xl border border-gray-100">
                        <div class="flex-1 pr-2">
                            <h4 class="font-bold text-gray-900 text-xs">${item.name}</h4>
                            <span class="text-[11px] text-gray-500">Rp ${item.price.toLocaleString('id-ID')}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="updateQty(${item.id}, -1)" class="w-6 h-6 bg-white border border-gray-200 rounded-lg text-xs font-extrabold flex items-center justify-center hover:bg-gray-100">-</button>
                            <span class="font-extrabold text-xs w-4 text-center">${item.qty}</span>
                            <button onclick="updateQty(${item.id}, 1)" class="w-6 h-6 bg-white border border-gray-200 rounded-lg text-xs font-extrabold flex items-center justify-center hover:bg-gray-100">+</button>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
            let tax = subtotal * 0.10;
            grandTotal = subtotal + tax;

            document.getElementById('tax-amount').innerText = 'Rp ' + tax.toLocaleString('id-ID');
            document.getElementById('total-amount').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
        }

        function openPaymentModal() {
            if (cart.length === 0) {
                alert('Keranjang masih kosong!');
                return;
            }
            document.getElementById('modal-total-display').value = 'Rp ' + grandTotal.toLocaleString('id-ID');
            document.getElementById('cart-data-input').value = JSON.stringify(cart);
            document.getElementById('pay-amount-input').value = '';
            document.getElementById('payment-modal').classList.remove('hidden');
        }

        function closePaymentModal() {
            document.getElementById('payment-modal').classList.add('hidden');
        }

        function setQuickPay(amount) {
            document.getElementById('pay-amount-input').value = amount;
        }

        function setExactPay() {
            document.getElementById('pay-amount-input').value = Math.ceil(grandTotal);
        }
    </script>

</body>
</html>