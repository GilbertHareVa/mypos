<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SeashellKitchen Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#fdf8f0] text-gray-800 flex h-screen overflow-hidden">

    <!-- Topbar Khusus HP (Hanya Muncul di Layar Kecil) -->
    <div class="md:hidden bg-white w-full flex items-center justify-between p-4 border-b border-[#f5deb3] fixed top-0 z-40 shadow-sm">
        <div class="font-bold text-xl text-[#5c3d1e]">☕ SeashellKitchen</div>
        <button onclick="toggleSidebar()" class="text-[#5c3d1e] focus:outline-none p-2 bg-[#fdf8f0] rounded-lg">
            <!-- Ikon Garis Tiga (Hamburger) -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>

    <!-- Latar Belakang Gelap saat Menu HP Terbuka -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <!-- Sidebar Menu -->
    <aside id="sidebar" class="bg-white w-64 border-r border-[#f5deb3] flex flex-col fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-300 ease-in-out z-40 h-full shadow-xl md:shadow-none">
        
        <div class="p-6 border-b border-[#f5deb3] flex justify-between items-center">
            <h2 class="text-2xl font-bold text-[#5c3d1e]">☕ SeashellKitchen</h2>
            <!-- Tombol Tutup (X) khusus di HP -->
            <button class="md:hidden text-gray-400 hover:text-red-500 focus:outline-none text-2xl font-bold" onclick="toggleSidebar()">&times;</button>
        </div>
        
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <a href="/admin/dashboard" class="block px-4 py-3 text-gray-600 hover:bg-[#f5deb3] hover:text-[#5c3d1e] rounded-lg font-medium transition">📊 Dashboard</a>
            <a href="/admin/menus" class="block px-4 py-3 text-gray-600 hover:bg-[#f5deb3] hover:text-[#5c3d1e] rounded-lg font-medium transition">🍔 Data Menu</a>
            <a href="/admin/transactions" class="block px-4 py-3 text-gray-600 hover:bg-[#f5deb3] hover:text-[#5c3d1e] rounded-lg font-medium transition">📝 Transaksi</a>
            <a href="/admin/reports" class="block px-4 py-3 text-gray-600 hover:bg-[#f5deb3] hover:text-[#5c3d1e] rounded-lg font-medium transition">📊 Laporan Penjualan</a>
            <a href="/admin/users" class="block px-4 py-3 text-gray-600 hover:bg-[#f5deb3] hover:text-[#5c3d1e] rounded-lg font-medium transition">👥 Data Karyawan</a>
            <a href="/admin/ingredients" class="block px-4 py-3 text-gray-600 hover:bg-[#f5deb3] hover:text-[#5c3d1e] rounded-lg font-medium transition">📦 Stok Bahan</a>
            <a href="/admin/settings" class="block px-4 py-3 text-gray-600 hover:bg-[#f5deb3] hover:text-[#5c3d1e] rounded-lg font-medium transition">⚙️ Pengaturan</a>
        </nav>

        <div class="p-4 border-t border-[#f5deb3] bg-gray-50">
            <div class="text-sm font-bold text-gray-700 mb-3 truncate">👤 {{ auth()->user()->name }}</div>
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-red-100 text-red-600 py-2 rounded-lg font-bold border border-red-200 hover:bg-red-200 transition">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Area Konten Utama -->
    <main class="flex-1 flex flex-col h-full overflow-hidden w-full pt-[72px] md:pt-0">
        <!-- Judul Halaman -->
        <header class="bg-white border-b border-[#f5deb3] p-4 md:p-6 shrink-0">
            <h1 class="text-xl md:text-2xl font-bold text-gray-800">@yield('title')</h1>
        </header>
        
        <!-- Isi Konten -->
        <div class="p-4 md:p-6 flex-1 overflow-y-auto bg-[#fdf8f0]">
            @yield('content')
        </div>
    </main>

    <!-- Script untuk animasi buka/tutup menu di HP -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            // Geser menu kiri-kanan
            sidebar.classList.toggle('-translate-x-full');
            // Tampilkan/Sembunyikan latar belakang gelap
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>