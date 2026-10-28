<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $setting->store_name ?? 'SeashellKitchen' }} - POS & Restaurant Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#fcfbf9] text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Top Navigation -->
    <nav class="bg-white/90 backdrop-blur-md border-b border-gray-200/70 fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#2c1810] text-amber-100 flex items-center justify-center font-bold shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <span class="font-extrabold text-lg text-[#2c1810] tracking-tight block leading-none">{{ $setting->store_name ?? 'SeashellKitchen' }}</span>
                    <span class="text-[10px] text-gray-400 font-semibold tracking-wider uppercase mt-1 block">Restaurant & POS System</span>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="/admin/dashboard" class="bg-[#2c1810] text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-[#3d2319] transition shadow-xs flex items-center gap-2">
                            <span>Dashboard Admin</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @else
                        <a href="/pos" class="bg-[#2c1810] text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-[#3d2319] transition shadow-xs flex items-center gap-2">
                            <span>Buka Kasir POS</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @endif
                @else
                    <a href="/login" class="bg-[#2c1810] text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-[#3d2319] transition shadow-xs flex items-center gap-2">
                        <span>Login Sistem</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-1 pt-32 pb-20 px-6">
        <div class="max-w-4xl mx-auto text-center space-y-6">
            <div class="inline-flex items-center gap-2 bg-amber-50/80 border border-amber-200/70 px-4 py-1.5 rounded-full text-amber-900 text-xs font-semibold tracking-wide uppercase shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-amber-600 animate-pulse"></span>
                <span>Operational & Management Platform</span>
            </div>

            <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 tracking-tight leading-tight">
                Selamat Datang di {{ $setting->store_name ?? 'SeashellKitchen' }}
            </h1>

            <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto font-normal leading-relaxed">
                {{ $setting->address ?? 'Jalan Pendidikan No. 14' }}
                @if(!empty($setting->phone))
                    <br><span class="text-sm text-gray-500 font-semibold inline-flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-amber-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        Kontak / WA: {{ $setting->phone }}
                    </span>
                @endif
            </p>

            <div class="flex justify-center gap-4 pt-2">
                @auth
                    <a href="/pos" class="bg-[#2c1810] text-white px-8 py-4 rounded-2xl font-extrabold text-sm hover:bg-[#3d2319] shadow-lg shadow-amber-950/10 transition active:scale-95 flex items-center gap-3">
                        <span>Masuk ke Sistem Kasir</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                @else
                    <a href="/login" class="bg-[#2c1810] text-white px-8 py-4 rounded-2xl font-extrabold text-sm hover:bg-[#3d2319] shadow-lg shadow-amber-950/10 transition active:scale-95 flex items-center gap-3">
                        <span>Masuk ke Sistem Kasir</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                @endauth
            </div>
        </div>

        <!-- SEKSI KATALOG MENU -->
        <div class="max-w-6xl mx-auto mt-20">
            <div class="text-center mb-10 space-y-1">
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Menu Restoran</h2>
                <p class="text-sm text-gray-500 font-medium">Pilihan hidangan berkualitas dari {{ $setting->store_name ?? 'SeashellKitchen' }}</p>
            </div>

            @if($menus->isEmpty())
                <div class="bg-white border border-gray-200 rounded-3xl p-12 text-center max-w-md mx-auto shadow-2xs">
                    <div class="w-14 h-14 rounded-2xl bg-gray-50 text-gray-400 flex items-center justify-center mx-auto mb-4 border border-gray-100">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-800 text-base">Menu Belum Tersedia</h4>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">Silakan masuk ke Panel Admin (menu <b>Data Menu</b>) untuk menambahkan hidangan pertama Anda.</p>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($menus as $menu)
                        @php
                            $imgUrl = $menu->image;
                            if ($imgUrl && !\Illuminate\Support\Str::startsWith($imgUrl, ['http://', 'https://'])) {
                                $imgUrl = asset('storage/' . $imgUrl);
                            }
                        @endphp
                        <div class="bg-white rounded-2xl overflow-hidden border border-gray-200/90 shadow-2xs hover:border-[#2c1810] hover:shadow-md transition duration-300 flex flex-col h-full group">
                            <div class="h-44 bg-gray-50 relative overflow-hidden border-b border-gray-100">
                                <img src="{{ $imgUrl }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.onerror=null; this.outerHTML='<div class=\'w-full h-full bg-gray-50 flex items-center justify-center text-gray-300\'><svg class=\'w-10 h-10\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253\'></path></svg></div>';">
                            </div>
                            <div class="p-5 flex-1 flex flex-col justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm leading-snug tracking-tight">{{ $menu->name }}</h4>
                                </div>
                                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                                    <span class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">Harga</span>
                                    <span class="font-extrabold text-[#2c1810] text-base">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Cards Highlight Fitur -->
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 mt-24">
            <div class="bg-white p-8 rounded-3xl border border-gray-200/90 shadow-2xs space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-[#2c1810] text-amber-100 flex items-center justify-center shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg tracking-tight">POS Kasir Cepat</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mt-1">Pencatatan pesanan instan, kalkulasi PPN otomatis, dan dukungan cetak struk thermal langsung.</p>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-gray-200/90 shadow-2xs space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-[#2c1810] text-amber-100 flex items-center justify-center shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg tracking-tight">Kontrol Stok Gudang</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mt-1">Pantau ketersediaan bahan baku secara real-time dengan notifikasi batas minimal otomatis.</p>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-gray-200/90 shadow-2xs space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-[#2c1810] text-amber-100 flex items-center justify-center shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg tracking-tight">Analisis Penjualan</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mt-1">Laporan pendapatan lengkap berbasis rentang tanggal untuk memudahkan evaluasi omzet bisnis.</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-8 text-center text-sm text-gray-500 space-y-2">
        <p>© {{ date('Y') }} <b class="text-gray-800">{{ $setting->store_name ?? 'SeashellKitchen' }}</b>. All rights reserved.</p>
        @if(!empty($setting->receipt_footer))
            <p class="text-xs text-gray-400 italic font-medium">"{{ $setting->receipt_footer }}"</p>
        @endif
    </footer>

</body>
</html>