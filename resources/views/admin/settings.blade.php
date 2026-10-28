@extends('layouts.admin')

@section('title', 'Pengaturan Restoran')

@section('content')
<div class="max-w-3xl space-y-6">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl font-semibold text-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-8 rounded-3xl border border-gray-200/80 shadow-2xs">
        <div class="mb-6 border-b border-gray-100 pb-4">
            <h3 class="text-xl font-extrabold text-gray-900">Identitas & Informasi Kafe</h3>
            <p class="text-sm text-gray-500 mt-1">Informasi ini akan ditampilkan di Landing Page dan Struk Kasir.</p>
        </div>

        <form action="{{ route('settings.update') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Bisnis / Restoran</label>
                <input type="text" name="store_name" value="{{ old('store_name', $setting->store_name ?? 'SeashellKitchen') }}" required placeholder="Contoh: SeashellKitchen" class="w-full border border-gray-200 rounded-2xl p-3.5 focus:border-[#2c1810] outline-none text-sm font-medium">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                <textarea name="address" rows="3" placeholder="Contoh: Jl. Pantai Indah No. 88, Jakarta Utara" class="w-full border border-gray-200 rounded-2xl p-3.5 focus:border-[#2c1810] outline-none text-sm font-medium">{{ old('address', $setting->address ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">No. Telepon / WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone', $setting->phone ?? '') }}" placeholder="Contoh: 0812-3456-7890" class="w-full border border-gray-200 rounded-2xl p-3.5 focus:border-[#2c1810] outline-none text-sm font-medium">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Pesan Footer Struk (Catatan Bawah Struk)</label>
                <input type="text" name="receipt_footer" value="{{ old('receipt_footer', $setting->receipt_footer ?? '') }}" placeholder="Contoh: Terima kasih atas kunjungan Anda! Sampai jumpa kembali." class="w-full border border-gray-200 rounded-2xl p-3.5 focus:border-[#2c1810] outline-none text-sm font-medium">
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-[#2c1810] hover:bg-[#3d2319] text-white px-8 py-3.5 rounded-2xl font-extrabold text-sm shadow-md transition active:scale-95">
                    💾 Simpan Semua Pengaturan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection