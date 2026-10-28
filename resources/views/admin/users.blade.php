@extends('layouts.admin')

@section('title', 'Data Karyawan')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl font-semibold text-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- Header & Tombol Tambah -->
    <div class="flex justify-between items-center">
        <div>
            <h3 class="text-xl font-extrabold text-gray-900">Daftar Pengguna & Staf</h3>
            <p class="text-sm text-gray-500 mt-1">Kelola akun akses sistem SeashellKitchen</p>
        </div>
        <button onclick="openAddModal()" class="bg-[#2c1810] hover:bg-[#3d2319] text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-md transition active:scale-95 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Karyawan
        </button>
    </div>

    <!-- Tabel Data Karyawan -->
    <div class="bg-white rounded-3xl border border-gray-200/90 shadow-2xs overflow-hidden">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-gray-50/70 border-b border-gray-100 text-gray-500 font-bold uppercase text-xs tracking-wider">
                    <th class="p-4 pl-6">Nama</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Hak Akses (Role)</th>
                    <th class="p-4 pr-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="p-4 pl-6 font-bold text-gray-900">{{ $user->name }}</td>
                    <td class="p-4 text-gray-600 font-medium">{{ $user->email }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $user->role === 'admin' ? 'bg-amber-100 text-amber-900' : 'bg-blue-100 text-blue-900' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="p-4 pr-6 text-right space-x-2">
                        <button onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->role }}')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                            Edit
                        </button>
                        @if(auth()->id() !== $user->id)
                            <form action="/admin/users/{{ $user->id }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold transition border border-red-200/60">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- MODAL POPUP (TAMBAH & EDIT) -->
<div id="user-modal" class="fixed inset-0 bg-black/50 backdrop-blur-xs hidden flex items-center justify-center z-50">
    <div class="bg-white w-[450px] rounded-3xl shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in zoom-in duration-200">
        <div class="bg-[#2c1810] text-white px-6 py-4 font-bold text-base flex justify-between items-center">
            <span id="modal-title">Tambah Karyawan</span>
            <button onclick="closeModal()" class="text-gray-300 hover:text-white text-xl font-bold">&times;</button>
        </div>

        <form id="user-form" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Lengkap</label>
                <input type="text" name="name" id="user-name" required class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:border-[#2c1810] outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
                <input type="email" name="email" id="user-email" required class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:border-[#2c1810] outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Hak Akses (Role)</label>
                <select name="role" id="user-role" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:border-[#2c1810] outline-none font-medium">
                    <option value="kasir">Kasir</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Password</label>
                <input type="password" name="password" id="user-password" placeholder="Kosongkan jika tidak ingin diubah" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:border-[#2c1810] outline-none">
                <p id="password-hint" class="text-[11px] text-gray-400 mt-1 hidden">* Kosongkan jika password tidak diganti</p>
            </div>

            <div class="pt-3">
                <button type="submit" class="w-full bg-[#2c1810] hover:bg-[#3d2319] text-white py-3 rounded-xl font-bold text-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('user-modal');
    const form = document.getElementById('user-form');
    const title = document.getElementById('modal-title');
    const methodInput = document.getElementById('form-method');
    const passwordHint = document.getElementById('password-hint');

    function openAddModal() {
        title.innerText = 'Tambah Karyawan Baru';
        form.action = '/admin/users';
        methodInput.value = 'POST';
        document.getElementById('user-name').value = '';
        document.getElementById('user-email').value = '';
        document.getElementById('user-role').value = 'kasir';
        document.getElementById('user-password').value = '';
        document.getElementById('user-password').required = true;
        passwordHint.classList.add('hidden');
        modal.classList.remove('hidden');
    }

    function openEditModal(id, name, email, role) {
        title.innerText = 'Edit Data Karyawan';
        form.action = '/admin/users/' + id;
        methodInput.value = 'PUT';
        document.getElementById('user-name').value = name;
        document.getElementById('user-email').value = email;
        document.getElementById('user-role').value = role;
        document.getElementById('user-password').value = '';
        document.getElementById('user-password').required = false;
        passwordHint.classList.remove('hidden');
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }
</script>
@endsection