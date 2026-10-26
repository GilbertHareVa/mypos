<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Kasir - MyPOS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#fdf8f0] h-screen flex flex-col overflow-hidden">
    
    <!-- Topbar Kasir Tipis -->
    <header class="bg-[#5c3d1e] text-white px-4 py-2 flex justify-between items-center text-sm shadow-md">
        <div class="font-bold text-lg">☕ MyPOS Kasir</div>
        <div class="flex items-center gap-4">
            <span id="clock" class="text-[#f5deb3]"></span>
            <span class="bg-[#4a3118] px-3 py-1 rounded-full">👤 {{ auth()->user()->name }}</span>
            <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-white font-medium transition">Logout</button>
            </form>
        </div>
    </header>

    <!-- Layout 3 Kolom Penuh Layar -->
    <div class="flex-1 flex overflow-hidden">
        
        <!-- KOLOM 1: Keranjang (Kiri) -->
        <div class="w-[280px] bg-white border-r border-[#f5deb3] flex flex-col">
            <div class="p-3 border-b flex justify-between items-center bg-gray-50 shrink-0">
                <span class="font-bold text-gray-700">Pesanan Baru</span>
                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded font-bold">Dine In</span>
            </div>
            
            <div id="cart-items" class="flex-1 overflow-y-auto p-3 flex flex-col gap-2 bg-gray-50/50">
                <div class="text-center text-gray-400 text-sm mt-10">Belum ada item di keranjang.</div>
            </div>
            
            <div class="p-4 border-t bg-gray-50 shrink-0 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between mb-1"><span class="text-gray-500 text-sm">Pajak (10%)</span><span id="tax-amount" class="font-medium text-sm">Rp 0</span></div>
                <div class="flex justify-between mb-3"><span class="text-gray-700 font-bold">Total</span><span id="total-amount" class="font-bold text-2xl text-[#5c3d1e]">Rp 0</span></div>
                <button onclick="openCheckout()" class="w-full bg-[#5c3d1e] text-white py-3 rounded-lg font-bold text-lg hover:bg-[#4a3118] shadow-md transition active:scale-95">💳 Bayar</button>
            </div>
        </div>

        <!-- KOLOM 2: Daftar Menu (Tengah) -->
        <div class="flex-1 bg-[#fdf8f0] p-4 flex flex-col overflow-hidden">
            <input type="text" placeholder="Cari menu minuman/makanan..." class="w-full p-3 rounded-xl border border-gray-300 mb-4 focus:outline-none focus:border-[#5c3d1e] shadow-sm text-sm shrink-0">
            
            <div class="flex-1 overflow-y-auto pr-2">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 pb-4">
                    @foreach($menus as $menu)
                    <div onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->name) }}', {{ $menu->price }})" class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 cursor-pointer hover:border-[#5c3d1e] hover:shadow-md transition flex flex-col h-full active:scale-95">
                        @php
                            $imgUrl = $menu->image;
                            if ($imgUrl && !\Illuminate\Support\Str::startsWith($imgUrl, ['http://', 'https://'])) {
                                $imgUrl = asset('storage/' . $imgUrl);
                            }
                        @endphp
                        <div class="h-28 w-full bg-gray-100 shrink-0">
                            <img src="{{ $imgUrl }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.outerHTML='<div class=\'w-full h-full bg-gray-200 flex items-center justify-center text-4xl\'>🍽️</div>';">
                        </div>
                        <div class="p-3 flex-1 flex flex-col justify-between pointer-events-none">
                            <h4 class="font-bold text-gray-800 text-sm line-clamp-2">{{ $menu->name }}</h4>
                            <p class="text-[#5c3d1e] font-bold mt-2 text-sm">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- KOLOM 3: Numpad (Kanan) -->
        <div class="w-[300px] bg-white border-l border-[#f5deb3] p-4 flex flex-col">
            <div class="flex gap-2 mb-4 shrink-0">
                <button class="flex-1 bg-[#5c3d1e] text-white py-2 rounded font-medium text-sm shadow-sm">Qty</button>
                <button class="flex-1 bg-gray-100 text-gray-600 hover:bg-gray-200 py-2 rounded font-medium text-sm transition">Diskon</button>
            </div>
            <div class="bg-gray-100 h-16 rounded-xl mb-4 flex items-center justify-end px-4 text-3xl font-bold text-gray-800 tracking-wider shrink-0 border border-gray-200">0</div>
            <div class="grid grid-cols-3 gap-3 flex-1">
                <button class="bg-gray-50 border border-gray-200 rounded-xl text-2xl font-bold hover:bg-gray-200">1</button>
                <button class="bg-gray-50 border border-gray-200 rounded-xl text-2xl font-bold hover:bg-gray-200">2</button>
                <button class="bg-gray-50 border border-gray-200 rounded-xl text-2xl font-bold hover:bg-gray-200">3</button>
                <button class="bg-gray-50 border border-gray-200 rounded-xl text-2xl font-bold hover:bg-gray-200">4</button>
                <button class="bg-gray-50 border border-gray-200 rounded-xl text-2xl font-bold hover:bg-gray-200">5</button>
                <button class="bg-gray-50 border border-gray-200 rounded-xl text-2xl font-bold hover:bg-gray-200">6</button>
                <button class="bg-gray-50 border border-gray-200 rounded-xl text-2xl font-bold hover:bg-gray-200">7</button>
                <button class="bg-gray-50 border border-gray-200 rounded-xl text-2xl font-bold hover:bg-gray-200">8</button>
                <button class="bg-gray-50 border border-gray-200 rounded-xl text-2xl font-bold hover:bg-gray-200">9</button>
                <button class="bg-gray-50 border border-gray-200 rounded-xl text-xl font-bold hover:bg-gray-200">000</button>
                <button class="bg-gray-50 border border-gray-200 rounded-xl text-2xl font-bold hover:bg-gray-200">0</button>
                <button class="bg-red-50 text-red-600 border border-red-200 rounded-xl text-xl font-bold hover:bg-red-100">CLEAR</button>
            </div>
        </div>
    </div>

    <!-- MODAL POPUP CHECKOUT -->
    <div id="checkout-modal" class="fixed inset-0 bg-black/60 hidden flex items-center justify-center z-50">
        <div class="bg-white w-[450px] rounded-2xl shadow-xl flex flex-col overflow-hidden">
            <div class="bg-[#5c3d1e] text-white p-4 font-bold text-lg flex justify-between items-center">
                <span>Pembayaran</span>
                <button onclick="closeCheckout()" class="text-white hover:text-red-300 text-xl font-bold">&times;</button>
            </div>
            
            <div class="p-6 flex flex-col gap-4">
                
                <!-- Rincian Produk yang Dibeli di dalam Modal -->
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-3 max-h-32 overflow-y-auto" id="modal-item-list">
                    <!-- Otomatis diisi oleh JavaScript -->
                </div>

                <div class="flex justify-between items-center bg-gray-100 p-4 rounded-xl">
                    <span class="font-bold text-gray-700">Total Tagihan</span>
                    <span id="modal-total" class="font-bold text-2xl text-[#5c3d1e]">Rp 0</span>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Uang Diterima (Nominal)</label>
                    <input type="number" id="paid-amount" class="w-full border-2 border-gray-300 rounded-lg p-3 text-2xl font-bold focus:border-[#5c3d1e] outline-none" oninput="calculateChange()">
                    
                    <div class="grid grid-cols-4 gap-2 mt-2">
                        <button onclick="addQuickAmount('pas')" class="bg-green-50 text-green-700 py-2 rounded border border-green-200 font-bold text-xs hover:bg-green-100">Uang Pas</button>
                        <button onclick="addQuickAmount(20000)" class="bg-gray-50 py-2 rounded border font-bold text-xs hover:bg-gray-200 text-gray-700">+20K</button>
                        <button onclick="addQuickAmount(50000)" class="bg-gray-50 py-2 rounded border font-bold text-xs hover:bg-gray-200 text-gray-700">+50K</button>
                        <button onclick="addQuickAmount(100000)" class="bg-gray-50 py-2 rounded border font-bold text-xs hover:bg-gray-200 text-gray-700">+100K</button>
                    </div>
                </div>

                <div class="flex justify-between items-center bg-orange-50 p-4 rounded-xl border border-orange-100">
                    <span class="font-bold text-orange-800">Kembalian</span>
                    <span id="modal-change" class="font-bold text-xl text-orange-600">Rp 0</span>
                </div>
            </div>
            
            <div class="p-4 border-t bg-gray-50">
                <button onclick="processPayment()" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-green-700 shadow-md">Selesaikan Transaksi</button>
            </div>
        </div>
    </div>

    <script>
        setInterval(() => { document.getElementById('clock').innerText = new Date().toLocaleString('id-ID'); }, 1000);

        let cart = [];
        const taxRate = 0.10;
        let currentGrandTotal = 0;

        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // FUNGSI MENAMBAH KE KERANJANG
        function addToCart(id, name, price) {
            let existingItem = cart.find(item => item.id === id);
            if (existingItem) { existingItem.qty += 1; } 
            else { cart.push({ id: id, name: name, price: price, qty: 1 }); }
            updateCartUI();
        }

        function updateCartUI() {
            const cartItemsContainer = document.getElementById('cart-items');
            if (cart.length === 0) {
                cartItemsContainer.innerHTML = '<div class="text-center text-gray-400 text-sm mt-10">Belum ada item di keranjang.</div>';
                document.getElementById('tax-amount').innerText = 'Rp 0';
                document.getElementById('total-amount').innerText = 'Rp 0';
                currentGrandTotal = 0;
                return;
            }

            let html = '';
            let subtotal = 0;

            cart.forEach((item, index) => {
                let itemTotal = item.price * item.qty;
                subtotal += itemTotal;
                html += `
                <div class="bg-white p-3 rounded-lg border border-gray-200 text-sm relative group shadow-sm">
                    <div class="font-bold text-gray-800 truncate pr-6">${item.name}</div>
                    <div class="flex justify-between items-center mt-2">
                        <div class="text-gray-500 font-medium">${item.qty} x ${formatRupiah(item.price)}</div>
                        <div class="font-bold text-[#5c3d1e]">${formatRupiah(itemTotal)}</div>
                    </div>
                    <button onclick="removeFromCart(${index})" class="absolute top-2 right-2 text-gray-300 hover:text-red-500 font-bold hidden group-hover:block transition">✕</button>
                </div>`;
            });

            let tax = subtotal * taxRate;
            currentGrandTotal = subtotal + tax;

            cartItemsContainer.innerHTML = html;
            document.getElementById('tax-amount').innerText = formatRupiah(tax);
            document.getElementById('total-amount').innerText = formatRupiah(currentGrandTotal);
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCartUI();
        }

        // FUNGSI MEMBUKA MENU BAYAR
        function openCheckout() {
            if (cart.length === 0) {
                Swal.fire({ icon: 'warning', title: 'Ups!', text: 'Keranjang masih kosong, pilih menu dulu ya.' });
                return;
            }
            
            // Masukkan rincian item ke dalam popup bayar
            let orderSummary = '';
            cart.forEach(item => {
                orderSummary += `<div class="flex justify-between text-sm mb-1"><span class="text-gray-600">${item.qty}x ${item.name}</span><span class="font-bold text-gray-800">${formatRupiah(item.price * item.qty)}</span></div>`;
            });
            document.getElementById('modal-item-list').innerHTML = orderSummary;

            document.getElementById('checkout-modal').classList.remove('hidden');
            document.getElementById('modal-total').innerText = formatRupiah(currentGrandTotal);
            document.getElementById('paid-amount').value = '';
            document.getElementById('modal-change').innerText = 'Rp 0';
        }

        function closeCheckout() {
            document.getElementById('checkout-modal').classList.add('hidden');
        }

        function calculateChange() {
            let paid = parseInt(document.getElementById('paid-amount').value) || 0;
            let change = paid - currentGrandTotal;
            if (change < 0) change = 0;
            document.getElementById('modal-change').innerText = formatRupiah(change);
        }

        function addQuickAmount(amount) {
            let input = document.getElementById('paid-amount');
            if (amount === 'pas') {
                input.value = currentGrandTotal;
            } else {
                let current = parseInt(input.value) || 0;
                input.value = current + amount;
            }
            calculateChange();
        }

        // FUNGSI PROSES PEMBAYARAN KE DATABASE
        function processPayment() {
            let paid = parseInt(document.getElementById('paid-amount').value) || 0;
            if (paid < currentGrandTotal) {
                Swal.fire({ icon: 'error', title: 'Uang Kurang', text: 'Nominal yang dibayarkan lebih kecil dari total tagihan.' });
                return;
            }

            Swal.fire({ title: 'Memproses Pembayaran...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});

            fetch('/pos/transaction/start', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart: cart,
                    paid_amount: paid,
                    payment_method: 'cash'
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Transaksi Berhasil!',
                        html: `No. Struk: <b>${data.invoice}</b><br>Kembalian: <b>${formatRupiah(data.change)}</b>`,
                        confirmButtonColor: '#5c3d1e',
                        confirmButtonText: 'Selesai & Tutup'
                    }).then(() => {
                        cart = []; 
                        updateCartUI(); 
                        closeCheckout(); 
                    });
                }
            })
            .catch(error => {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan sistem saat mengirim data.' });
            });
        }
    </script>
</body>
</html>