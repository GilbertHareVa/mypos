<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = DB::table('ingredients')
            ->leftJoin('suppliers', 'ingredients.supplier_id', '=', 'suppliers.id')
            ->select('ingredients.*', 'suppliers.name as supplier_name')
            ->orderBy('ingredients.name')
            ->get();
        return view('admin.ingredients', compact('ingredients'));
    }

    public function create()
    {
        // Ambil data supplier untuk dimasukkan ke pilihan dropdown
        $suppliers = DB::table('suppliers')->get();
        return view('admin.ingredient_create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|numeric|min:0',
            'min_stock' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'cost_per_unit' => 'required|numeric|min:0',
        ]);

        DB::table('ingredients')->insert([
            'supplier_id' => $request->supplier_id,
            'name' => $request->name,
            'stock' => $request->stock,
            'min_stock' => $request->min_stock,
            'unit' => $request->unit,
            'cost_per_unit' => $request->cost_per_unit,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('ingredients.index')->with('success', 'Bahan baku baru berhasil ditambahkan ke gudang!');
    }

    public function destroy($id)
    {
        DB::table('ingredients')->where('id', $id)->delete();
        return redirect()->route('ingredients.index')->with('success', 'Bahan baku berhasil dihapus!');
    }
}