<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IngredientController extends Controller
{
    public function index()
    {
        // Mengambil data bahan baku dan menggabungkannya dengan nama supplier/pemasok
        $ingredients = DB::table('ingredients')
            ->leftJoin('suppliers', 'ingredients.supplier_id', '=', 'suppliers.id')
            ->select('ingredients.*', 'suppliers.name as supplier_name')
            ->orderBy('ingredients.name')
            ->get();

        return view('admin.ingredients', compact('ingredients'));
    }
}