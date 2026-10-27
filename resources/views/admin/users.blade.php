@extends('layouts.admin')

@section('title', 'Manajemen Karyawan')

@section('content')
<div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm">
    
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-gray-800">Daftar Akun Sistem</h3>
        <a href="{{ route('users.create') }}" class="bg-[#5c3d1e] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#4a3118] transition inline-block">
            + Tambah Kasir Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 font-medium border border-green-200">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 font-medium border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-[#fdf8f0] text-gray-700 font-bold border-b border-[#f5deb3]">
                <tr>
                    <th class="py-3 px-4">Nama Lengkap</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Posisi (Role)</th>
                    <th class="py-3 px-4">Status Akun</th>
                    <th class="py-3 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-3 px-4 font-bold text-gray-800">{{ $user->name }}</td>
                    <td class="py-3 px-4 text-gray-600">{{ $user->email }}</td>
                    <td class="py-3 px-4">
                        @if($user->role === 'admin')
                            <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded font-bold text-xs uppercase">👑 Admin</span>
                        @else
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded font-bold text-xs uppercase">🧑‍💼 Kasir</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        @if($user->is_active)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded font-bold text-xs">Aktif</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded font-bold text-xs">Nonaktif</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 flex gap-3">
                        <button class="text-blue-600 hover:underline font-medium">Edit</button>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun {{ $user->name }}? Akses loginnya akan dicabut.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection