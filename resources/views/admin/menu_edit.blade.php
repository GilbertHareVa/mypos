@extends('layouts.admin')

@section('title', 'Edit Menu')

@section('content')
<div class="bg-white p-8 rounded-xl border border-[#f5deb3] shadow-sm max-w-2xl">
    
    <div class="mb-6 border-b border-gray-200 pb-4">
        <h3 class="text-xl font-bold text-gray-800">Ubah Data Menu</h3>
    </div>

    <!-- Tambahkan method PUT untuk Edit Data -->
    <form action="{{ route('menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Menu</label>
            <input type="text" name="name" value="{{ $menu->name }}" required class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] focus:ring-1 outline-none">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                <select name="category_id" required class="w-full border border-gray-300 rounded-lg p-3 outline-none bg-white">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $menu->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Harga (Rp)</label>
                <input type="number" name="price" value="{{ $menu->price }}" required min="0" class="w-full border border-gray-300 rounded-lg p-3 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Status Tersedia?</label>
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_available" value="1" class="w-5 h-5 text-[#5c3d1e] rounded focus:ring-[#5c3d1e]" {{ $menu->is_available ? 'checked' : '' }}>
                <span class="ml-2 text-gray-700">Ya, menu ini bisa dipesan</span>
            </label>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Ganti Foto (Opsional)</label>
            <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2 text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-[#fdf8f0] file:text-[#5c3d1e]">
            <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="bg-[#5c3d1e] text-white px-6 py-2.5 rounded-lg font-bold hover:bg-[#4a3118] transition shadow-md">Update Menu</button>
            <a href="{{ route('menus.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-lg font-bold hover:bg-gray-200 transition">Batal</a>
        </div>
    </form>

</div>
@endsection