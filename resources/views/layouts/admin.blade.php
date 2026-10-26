<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPOS - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#fdf8f0] flex h-screen overflow-hidden">

    <!-- Sidebar Kiri -->
    <aside class="w-[240px] bg-white border-r border-[#f5deb3] flex flex-col justify-between">
        <div>
            <div class="p-6 text-center border-b border-[#f5deb3]">
                <h1 class="text-2xl font-bold text-[#5c3d1e]">☕ MyPOS</h1>
            </div>
            <nav class="p-4 space-y-2">
                <a href="/admin/dashboard" class="block px-4 py-3 bg-[#5c3d1e] text-white rounded-lg font-medium">📊 Dashboard</a>
                <a href="#" class="block px-4 py-3 text-gray-600 hover:bg-[#f5deb3] hover:text-[#5c3d1e] rounded-lg font-medium transition">🍔 Data Menu</a>
                <a href="#" class="block px-4 py-3 text-gray-600 hover:bg-[#f5deb3] hover:text-[#5c3d1e] rounded-lg font-medium transition">📝 Transaksi</a>
            </nav>
        </div>
        
        <!-- Info User & Logout -->
        <div class="p-4 border-t border-[#f5deb3]">
            <p class="text-sm font-semibold text-gray-800 mb-2">Halo, {{ auth()->user()->name }}</p>
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-red-50 text-red-600 px-4 py-2 rounded-lg font-medium hover:bg-red-100 transition">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Area Konten Utama -->
    <main class="flex-1 overflow-y-auto">
        <!-- Topbar -->
        <header class="bg-white border-b border-[#f5deb3] px-8 py-4 flex justify-between items-center sticky top-0">
            <h2 class="text-xl font-bold text-gray-800">@yield('title', 'Dashboard')</h2>
            <div class="text-sm text-gray-500" id="clock"></div>
        </header>

        <!-- Isi Konten Halaman -->
        <div class="p-8">
            @yield('content')
        </div>
    </main>

    <script>
        setInterval(() => {
            document.getElementById('clock').innerText = new Date().toLocaleString('id-ID');
        }, 1000);
    </script>
</body>
</html>