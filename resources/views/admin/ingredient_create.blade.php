@extends('layouts.admin')

@section('title', 'Tambah Stok Bahan Baku')

@section('content')
<div class="bg-white p-8 rounded-xl border border-[#f5deb3] shadow-sm max-w-2xl">
    
    <div class="mb-6 border-b border-gray-200 pb-4">
        <h3 class="text-xl font-bold text-gray-800">Detail Bahan Baku</h3>
        <p class="text-sm text-gray-500">Masukkan informasi barang yang baru masuk ke gudang.</p>
    </div>

    <form action="{{ route('ingredients.store') }}" method="POST" class="space-y-5">
        @csrf
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Bahan</label>
            <input type="text" name="name" required placeholder="Contoh: Susu UHT, Gula Pasir..." class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Jumlah Stok Masuk</label>
                <input type="number" name="stock" required min="0" placeholder="0" class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Batas Minimal (Peringatan)</label>
                <input type="number" name="min_stock" required min="0" placeholder="Misal: 10" class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Satuan</label>
                <input type="text" name="unit" required placeholder="Kg, Liter, Pcs, Gram..." class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Harga Beli per Satuan (Rp)</label>
                <input type="number" name="cost_per_unit" required min="0" class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Supplier (Opsional)</label>
            <select name="supplier_id" class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none bg-white">
                <option value="">-- Tidak ada supplier --</option>
                @foreach($suppliers as $sup)
                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="bg-[#5c3d1e] text-white px-6 py-2.5 rounded-lg font-bold hover:bg-[#4a3118] transition shadow-md">Simpan Bahan</button>
            <a href="{{ route('ingredients.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-lg font-bold hover:bg-gray-200 transition">Batal</a>
        </div>
    </form>

</div>
@endsection