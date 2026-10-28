<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $setting = DB::table('settings')->first();
        return view('admin.settings', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'receipt_footer' => 'nullable|string',
        ]);

        // Cek apakah data settings sudah ada di database
        $exists = DB::table('settings')->where('id', 1)->exists();

        if ($exists) {
            DB::table('settings')->where('id', 1)->update([
                'store_name' => $request->store_name,
                'address' => $request->address,
                'phone' => $request->phone,
                'receipt_footer' => $request->receipt_footer,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('settings')->insert([
                'id' => 1,
                'store_name' => $request->store_name,
                'address' => $request->address,
                'phone' => $request->phone,
                'receipt_footer' => $request->receipt_footer,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}