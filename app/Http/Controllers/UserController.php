<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        // Mengambil semua data pengguna/karyawan
        $users = DB::table('users')->orderBy('role')->get();
        return view('admin.users', compact('users'));
    }
}