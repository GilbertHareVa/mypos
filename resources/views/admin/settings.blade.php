@extends('layouts.admin')

@section('title', 'Pengaturan Sistem & Struk')

@section('content')
<div class="max-w-4xl">
    
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 font-bold border border-green-200">
            ✅ {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Bagian 1: Profil Cafe -->
        <div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm">
            <h3 class="text-lg font-bold text-[#5c3d1e] mb-4 border-b border-gray-100 pb-2">🏠 Profil Restoran / Cafe</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Bisnis</label>
                    <input type="text" name="cafe_name" value="{{ $settings['cafe_name'] ?? '' }}" required class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Telepon (WhatsApp)</label>
                    <input type="text" name="cafe_phone" value="{{ $settings['cafe_phone'] ?? '' }}" required class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea name="cafe_address" required rows="2" class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none">{{ $settings['cafe_address'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Bagian 2: Pajak & Struk -->
        <div class="bg-white p-6 rounded-xl border border-[#f5deb3] shadow-sm">
            <h3 class="text-lg font-bold text-[#5c3d1e] mb-4 border-b border-gray-100 pb-2">🖨️ Pengaturan Struk & Pajak</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Pajak / PPN (%)</label>
                    <input type="number" name="tax_percentage" value="{{ $settings['tax_percentage'] ?? '10' }}" required min="0" max="100" class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none">
                    <p class="text-xs text-gray-500 mt-1">Sistem kasir akan menghitung pajak otomatis berdasarkan angka ini.</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Pesan Penutup di Struk (Tagline)</label>
                    <input type="text" name="cafe_tagline" value="{{ $settings['cafe_tagline'] ?? '' }}" required class="w-full border border-gray-300 rounded-lg p-3 focus:border-[#5c3d1e] outline-none">
                    <p class="text-xs text-gray-500 mt-1">Contoh: "Terima kasih atas kunjungannya!"</p>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan -->
        <div class="flex justify-end">
            <button type="submit" class="bg-[#5c3d1e] text-white px-8 py-3 rounded-xl font-bold hover:bg-[#4a3118] shadow-lg transition active:scale-95 text-lg">
                💾 Simpan Semua Pengaturan
            </button>
        </div>
    </form>

</div>
@endsection