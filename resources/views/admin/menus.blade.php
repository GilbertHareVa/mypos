@extends('layouts.admin')

@section('title', 'Data Menu')

@section('content')
<div class="space-y-6">

    @if(session('success'))
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl font-semibold text-sm space-y-1">
            @foreach($errors->all() as $error)
                <p>⚠️ {{ $error }}</p>
            @endforeach
        </div>
    @endif
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl font-semibold text-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- Header & Tombol Tambah -->
    <div class="flex justify-between items-center">
        <div>
            <h3 class="text-xl font-extrabold text-gray-900">Katalog Menu</h3>
            <p class="text-sm text-gray-500 mt-1">Kelola makanan dan minuman yang dijual di SeashellKitchen</p>
        </div>
        <button onclick="openAddModal()" class="bg-[#2c1810] hover:bg-[#3d2319] text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-md transition active:scale-95 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Menu Baru
        </button>
    </div>

    <!-- Tabel Data Menu -->
    <div class="bg-white rounded-3xl border border-gray-200/90 shadow-2xs overflow-hidden">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-gray-50/70 border-b border-gray-100 text-gray-500 font-bold uppercase text-xs tracking-wider">
                    <th class="p-4 pl-6">Foto</th>
                    <th class="p-4">Nama Menu</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Harga</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 pr-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($menus as $menu)
                    @php
                        $imgUrl = $menu->image;
                        if ($imgUrl && !\Illuminate\Support\Str::startsWith($imgUrl, ['http://', 'https://'])) {
                            $imgUrl = asset('storage/' . $imgUrl);
                        }
                    @endphp
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="p-4 pl-6">
                            <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden border border-gray-200">
                                <img src="{{ $imgUrl }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.outerHTML='<div class=\'w-full h-full bg-amber-50 flex items-center justify-center text-xs font-bold text-amber-900\'>🍽️</div>';">
                            </div>
                        </td>
                        <td class="p-4 font-bold text-gray-900">{{ $menu->name }}</td>
                        <td class="p-4 text-gray-500 font-medium">{{ $menu->category->name ?? $menu->category ?? 'Umum' }}</td>
                        <td class="p-4 font-extrabold text-[#2c1810]">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Tersedia</span>
                        </td>
                        <td class="p-4 pr-6 text-right space-x-2">
                            <form action="/admin/menus/{{ $menu->id }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold transition border border-red-200/60">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400 font-medium">Belum ada menu. Silakan klik tombol "Tambah Menu Baru".</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- MODAL POPUP TAMBAH MENU -->
<div id="menu-modal" class="fixed inset-0 bg-black/50 backdrop-blur-xs hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in zoom-in duration-200">
        <div class="bg-[#2c1810] text-white px-6 py-4 font-bold text-base flex justify-between items-center">
            <span>Tambah Menu Baru</span>
            <button onclick="closeModal()" class="text-gray-300 hover:text-white text-xl font-bold">&times;</button>
        </div>

        <form action="/admin/menus" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Menu</label>
                <input type="text" name="name" required placeholder="Contoh: Nasi Goreng Seafood" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:border-[#2c1810] outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kategori</label>
                <input type="text" name="category" placeholder="Contoh: Makanan / Minuman" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:border-[#2c1810] outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Harga (Rp)</label>
                <input type="number" name="price" required placeholder="25000" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:border-[#2c1810] outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Foto Menu (Opsional)</label>
                <input type="file" name="image" accept="image/*" class="w-full border border-gray-200 rounded-xl p-2 text-xs text-gray-500 focus:border-[#2c1810] outline-none">
            </div>

            <div class="pt-3">
                <button type="submit" class="w-full bg-[#2c1810] hover:bg-[#3d2319] text-white py-3 rounded-xl font-bold text-sm transition">
                    Simpan Menu
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('menu-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('menu-modal').classList.add('hidden');
    }
</script>
@endsection