<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->orderBy('role')->get();
        return view('admin.users', compact('users'));
    }

    public function create()
    {
        return view('admin.user_create');
    }

    public function store(Request $request)
    {
        // Validasi data (Perhatikan in:admin,kasir)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,kasir' 
        ]);

        // Simpan ke database
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('users.index')->with('success', 'Akun karyawan baru berhasil dibuat!');
    }

    public function destroy($id)
    {
        if (auth()->id() == $id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('users.index')->with('success', 'Akun karyawan berhasil dihapus secara permanen!');
    }
}