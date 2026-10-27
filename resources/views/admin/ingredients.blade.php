@extends('layouts.admin')

@section('title', 'Stok Bahan Baku')

@section('content')
<div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm">
    
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-gray-800">Pemantauan Stok Gudang</h3>
        <a href="{{ route('ingredients.create') }}" class="bg-[#5c3d1e] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#4a3118] transition inline-block">
            + Tambah Bahan
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 font-medium border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-[#fdf8f0] text-gray-700 font-bold border-b border-[#f5deb3]">
                <tr>
                    <th class="py-3 px-4">Nama Bahan</th>
                    <th class="py-3 px-4">Sisa Stok</th>
                    <th class="py-3 px-4">Satuan</th>
                    <th class="py-3 px-4">Harga Beli / Unit</th>
                    <th class="py-3 px-4">Supplier</th>
                    <th class="py-3 px-4">Status Stok</th>
                    <th class="py-3 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ingredients as $item)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-3 px-4 font-bold text-gray-800">{{ $item->name }}</td>
                    
                    <td class="py-3 px-4 font-bold text-lg {{ $item->stock <= $item->min_stock ? 'text-red-600' : 'text-green-600' }}">
                        {{ $item->stock }}
                    </td>
                    
                    <td class="py-3 px-4 text-gray-600">{{ $item->unit }}</td>
                    <td class="py-3 px-4 text-[#5c3d1e]">Rp {{ number_format($item->cost_per_unit, 0, ',', '.') }}</td>
                    <td class="py-3 px-4 text-gray-600">{{ $item->supplier_name ?? 'Tanpa Supplier' }}</td>
                    <td class="py-3 px-4">
                        @if($item->stock <= $item->min_stock)
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded font-bold text-xs uppercase animate-pulse">Menipis!</span>
                        @else
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded font-bold text-xs uppercase">Aman</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        <form action="{{ route('ingredients.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus bahan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                
                @if($ingredients->isEmpty())
                <tr>
                    <td colspan="7" class="py-6 text-center text-gray-500">Belum ada data bahan baku.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>
@endsection