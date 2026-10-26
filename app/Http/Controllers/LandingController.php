<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories')->orderBy('sort_order')->get();
        $menus = DB::table('menus')->where('is_available', true)->get();
        
        return view('landing', compact('categories', 'menus'));
    }
}