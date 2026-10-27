<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeashellKitchen Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#fdf8f0] text-gray-800">

    <!-- Navbar -->
    <nav class="fixed w-full bg-white/90 backdrop-blur-sm shadow-sm z-50">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-[#5c3d1e]">☕ SeashellKitchen Cafe</h1>
            <div class="hidden md:flex gap-6 font-medium text-gray-600">
                <a href="#beranda" class="hover:text-[#5c3d1e] transition">Beranda</a>
                <a href="#tentang" class="hover:text-[#5c3d1e] transition">Tentang Kami</a>
                <a href="#menu" class="hover:text-[#5c3d1e] transition">Menu</a>
                <a href="#kontak" class="hover:text-[#5c3d1e] transition">Kontak</a>
            </div>
            <a href="/login" class="bg-[#5c3d1e] text-white px-5 py-2 rounded-full font-semibold hover:bg-[#4a3118] transition">Login Karyawan</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="pt-32 pb-20 px-4 bg-gradient-to-br from-[#5c3d1e] to-[#8a5a2b] text-center text-white">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-5xl md:text-6xl font-bold mb-6">Secangkir Semangat<br>Setiap Hari</h2>
            <p class="text-lg md:text-xl text-[#f5deb3] mb-10 max-w-2xl mx-auto">Nikmati sajian kopi terbaik dan hidangan lezat di SeashellKitchen Cafe. Tempat yang nyaman untuk berkumpul, bekerja, atau sekadar bersantai.</p>
            <a href="#menu" class="bg-[#f5deb3] text-[#5c3d1e] px-8 py-3 rounded-full font-bold text-lg hover:bg-white transition inline-block shadow-lg">Lihat Menu Kami</a>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="py-20 px-4 max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <h3 class="text-3xl font-bold text-[#5c3d1e] mb-4">Menu Favorit SeashellKitchen</h3>
            
            <!-- Filter Kategori (Fungsional dengan JavaScript nanti) -->
            <div class="flex flex-wrap justify-center gap-3 mt-8">
                @foreach($categories as $cat)
                    <button class="menu-filter bg-white border border-[#5c3d1e] text-[#5c3d1e] px-4 py-2 rounded-full font-medium hover:bg-[#5c3d1e] hover:text-white transition" data-filter="{{ $cat->id }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($menus as $menu)
            <div class="menu-card bg-white rounded-2xl overflow-hidden shadow-sm border border-[#f5deb3] hover:shadow-lg transition" data-category="{{ $menu->category_id }}">
                @php
                    $imgUrl = $menu->image;
                    if ($imgUrl && !\Illuminate\Support\Str::startsWith($imgUrl, ['http://', 'https://'])) {
                        $imgUrl = asset('storage/' . $imgUrl);
                    }
                @endphp
                <div class="h-48 w-full bg-gray-100">
                    <img src="{{ $imgUrl }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.outerHTML='<div class=\'w-full h-full bg-gray-200 flex items-center justify-center text-5xl\'>🍽️</div>';">
                </div>
                <div class="p-5">
                    <h4 class="font-bold text-lg text-gray-800 mb-1 line-clamp-1">{{ $menu->name }}</h4>
                    <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $menu->description ?? 'Nikmati kesegaran dan kelezatan menu spesial kami ini.' }}</p>
                    <div class="font-bold text-[#5c3d1e] text-lg">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-[#3a2613] text-white py-12 text-center">
        <h3 class="text-2xl font-bold text-[#f5deb3] mb-4">Kunjungi Kami</h3>
        <p class="text-gray-300 mb-2">Jl. Kopi Harum No. 123, Jakarta</p>
        <p class="text-gray-300 mb-6">Buka Setiap Hari: 08:00 - 22:00</p>
        <p class="text-gray-500 text-sm">© 2026 SeashellKitchen Cafe. Dibuat dengan semangat.</p>
    </footer>

    <script>
        // Logika sederhana untuk filter menu
        const filterBtns = document.querySelectorAll('.menu-filter');
        const menuCards = document.querySelectorAll('.menu-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Hapus warna aktif dari semua tombol
                filterBtns.forEach(b => { b.classList.remove('bg-[#5c3d1e]', 'text-white'); b.classList.add('bg-white', 'text-[#5c3d1e]'); });
                // Tambah warna aktif ke tombol yang diklik
                btn.classList.remove('bg-white', 'text-[#5c3d1e]');
                btn.classList.add('bg-[#5c3d1e]', 'text-white');

                const filter = btn.getAttribute('data-filter');
                
                menuCards.forEach(card => {
                    // ID 1 biasanya adalah 'Semua'
                    if (filter === '1' || card.getAttribute('data-category') === filter) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
        
        // Aktifkan tombol pertama secara default
        if(filterBtns.length > 0) filterBtns[0].click();
    </script>
</body>
</html>