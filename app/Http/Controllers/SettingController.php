<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SettingController extends Controller
{
    public function index()
    {
        // Mengambil data pengaturan dan mengubahnya menjadi format Array [key => value]
        $settings = DB::table('settings')->pluck('value', 'key')->toArray();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        // Mengambil semua inputan kecuali token keamanan
        $data = $request->except(['_token']);
        
        // Memperbarui data satu per satu ke database
        foreach ($data as $key => $value) {
            DB::table('settings')
                ->where('key', $key)
                ->update([
                    'value' => $value,
                    'updated_at' => Carbon::now()
                ]);
        }

        return redirect()->back()->with('success', 'Pengaturan sistem berhasil disimpan!');
    }
}