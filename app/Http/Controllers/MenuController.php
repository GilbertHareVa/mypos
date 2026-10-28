<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $menus = DB::table('menus')->orderBy('id', 'desc')->get();
        return view('admin.menus', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        DB::table('menus')->insert([
            'name' => $request->name,
            'category' => $request->category ?? 'Umum',
            'category_id' => null,
            'price' => $request->price,
            'image' => $imagePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/menus')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        DB::table('menus')->where('id', $id)->delete();
        return redirect('/admin/menus')->with('success', 'Menu berhasil dihapus!');
    }
}