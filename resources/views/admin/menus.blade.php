@extends('layouts.admin')

@section('title', 'Manajemen Data Menu')

@section('content')
<div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm">
    
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-gray-800">Daftar Menu Tersedia</h3>
        <!-- Tombol Tambah (Fungsinya akan kita buat nanti) -->
        <a href="{{ route('menus.create') }}" class="bg-[#5c3d1e] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#4a3118] transition inline-block"> + Tambah Menu Baru </a>
        </button>
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
                    <th class="py-3 px-4">Foto</th>
                    <th class="py-3 px-4">Nama Menu</th>
                    <th class="py-3 px-4">Kategori</th>
                    <th class="py-3 px-4">Harga</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $menu)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-3 px-4">
                        @php
                            $imgUrl = $menu->image;
                            if ($imgUrl && !\Illuminate\Support\Str::startsWith($imgUrl, ['http://', 'https://'])) {
                                $imgUrl = asset('storage/' . $imgUrl);
                            }
                        @endphp
                        <img src="{{ $imgUrl }}" class="w-12 h-12 object-cover rounded shadow-sm" onerror="this.style.display='none'">
                    </td>
                    <td class="py-3 px-4 font-bold text-gray-800">{{ $menu->name }}</td>
                    <td class="py-3 px-4 text-gray-600">{{ $menu->category_name }}</td>
                    <td class="py-3 px-4 font-bold text-[#5c3d1e]">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td class="py-3 px-4">
                        @if($menu->is_available)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded font-bold text-xs">Tersedia</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded font-bold text-xs">Habis</span>
                        @endif
                    </td>
                    <<td class="py-3 px-4 flex gap-3">
    <a href="{{ route('menus.edit', $menu->id) }}" class="text-blue-600 hover:underline font-medium">Edit</a>
    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus menu {{ $menu->name }}?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
    </form>
</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection