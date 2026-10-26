<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        // Mengambil data menu dan menggabungkannya dengan tabel kategori
        $menus = DB::table('menus')
            ->join('categories', 'menus.category_id', '=', 'categories.id')
            ->select('menus.*', 'categories.name as category_name')
            ->orderBy('menus.category_id')
            ->get();

        return view('admin.menus', compact('menus'));
    }
}