<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MenuController extends Controller
{
    public function index()
    {
        $menus = DB::table('menus')->join('categories', 'menus.category_id', '=', 'categories.id')
            ->select('menus.*', 'categories.name as category_name')->orderBy('menus.category_id')->get();
        return view('admin.menus', compact('menus'));
    }

    public function create()
    {
        $categories = DB::table('categories')->orderBy('sort_order')->get();
        return view('admin.menu_create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'category_id' => 'required|integer', 'price' => 'required|numeric|min:0', 'image' => 'nullable|image|max:2048']);
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('menus', 'public') : null;

        DB::table('menus')->insert(['category_id' => $request->category_id, 'name' => $request->name, 'price' => $request->price, 'image' => $imagePath, 'is_available' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        return redirect()->route('menus.index')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    // --- FUNGSI BARU: EDIT, UPDATE, & HAPUS ---
    public function edit($id)
    {
        $menu = DB::table('menus')->where('id', $id)->first();
        $categories = DB::table('categories')->orderBy('sort_order')->get();
        return view('admin.menu_edit', compact('menu', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255', 'category_id' => 'required|integer', 'price' => 'required|numeric|min:0', 'image' => 'nullable|image|max:2048']);
        $menu = DB::table('menus')->where('id', $id)->first();
        $imagePath = $menu->image; // Gunakan gambar lama secara default

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public'); // Ganti jika ada gambar baru
        }

        DB::table('menus')->where('id', $id)->update([
            'category_id' => $request->category_id, 'name' => $request->name, 'price' => $request->price, 'image' => $imagePath, 
            'is_available' => $request->has('is_available'), // Checkbox ketersediaan
            'updated_at' => Carbon::now()
        ]);
        return redirect()->route('menus.index')->with('success', 'Data menu berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DB::table('menus')->where('id', $id)->delete();
        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus secara permanen!');
    }
}