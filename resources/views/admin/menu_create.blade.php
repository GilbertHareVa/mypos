@extends('layouts.admin')

@section('title', 'Tambah Menu Baru')

@section('content')
<div class="bg-white p-8 rounded-xl border border-[#f5deb3] shadow-sm max-w-2xl">
    
    <div class="mb-6 border-b border-gray-200 pb-4">
        <h3 class="text-xl font-bold text-gray-800">Detail Menu</h3>
        <p class="text-sm text-gray-500">Masukkan informasi makanan atau minuman baru.</p>
    </div>

    <!-- Form wajib menggunakan enctype="multipart/form-data" agar bisa upload foto -->
    <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Menu</label>
            <input type="text" name="name" required placeholder="Contoh: Kopi Susu Aren" class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] focus:ring-1 focus:ring-[#5c3d1e] outline-none">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                <select name="category_id" required class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] focus:ring-1 focus:ring-[#5c3d1e] outline-none bg-white">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Harga (Rp)</label>
                <input type="number" name="price" required placeholder="25000" min="0" class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] focus:ring-1 focus:ring-[#5c3d1e] outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Upload Foto Menu</label>
            <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2 text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-[#fdf8f0] file:text-[#5c3d1e] hover:file:bg-[#f5deb3] transition">
            <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maksimal 2MB.</p>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="bg-[#5c3d1e] text-white px-6 py-2.5 rounded-lg font-bold hover:bg-[#4a3118] transition shadow-md">Simpan Menu</button>
            <a href="{{ route('menus.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-lg font-bold hover:bg-gray-200 transition">Batal</a>
        </div>
    </form>

</div>
@endsection