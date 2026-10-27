@extends('layouts.admin')

@section('title', 'Tambah Akun Karyawan')

@section('content')
<div class="bg-white p-8 rounded-xl border border-[#f5deb3] shadow-sm max-w-xl">
    
    <div class="mb-6 border-b border-gray-200 pb-4">
        <h3 class="text-xl font-bold text-gray-800">Detail Akun Baru</h3>
        <p class="text-sm text-gray-500">Karyawan akan menggunakan Email dan Password ini untuk Login.</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm border border-red-200">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="space-y-5">
        @csrf
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" required placeholder="Contoh: Budi Santoso" class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Email</label>
            <input type="email" name="email" required placeholder="budi@SeashellKitchen.com" class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Posisi (Role)</label>
                <select name="role" required class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none bg-white">
                    <!-- Nilai value di sini harus persis sama dengan di Controller -->
                    <option value="kasir">🧑‍💼 Kasir (Akses POS)</option>
                    <option value="admin">👑 Admin (Akses Penuh)</option>
                </select>
            </div>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="bg-[#5c3d1e] text-white px-6 py-2.5 rounded-lg font-bold hover:bg-[#4a3118] transition shadow-md">Buat Akun</button>
            <a href="{{ route('users.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-lg font-bold hover:bg-gray-200 transition">Batal</a>
        </div>
    </form>

</div>
@endsection