<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Buat Data Supplier (Pemasok)
        $supplierId = DB::table('suppliers')->insertGetId([
            'name' => 'PT Makmur Kopi Nusantara',
            'contact_person' => 'Bapak Budi',
            'phone' => '081299887766',
            'address' => 'Jl. Kebun Kopi No. 99, Jakarta',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // 2. Buat Data Bahan Baku
        DB::table('ingredients')->insert([
            [
                'supplier_id' => $supplierId,
                'name' => 'Biji Kopi Arabica (Roasted)',
                'stock' => 25,
                'min_stock' => 10,
                'unit' => 'Kg',
                'cost_per_unit' => 150000,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'supplier_id' => $supplierId,
                'name' => 'Susu UHT Full Cream',
                'stock' => 5, // Sengaja dibuat sangat sedikit agar indikator merah menyala
                'min_stock' => 12,
                'unit' => 'Liter',
                'cost_per_unit' => 18000,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'supplier_id' => $supplierId,
                'name' => 'Gula Aren Cair',
                'stock' => 15,
                'min_stock' => 5,
                'unit' => 'Botol',
                'cost_per_unit' => 35000,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'supplier_id' => $supplierId,
                'name' => 'Cup Plastik + Sablon MyPOS',
                'stock' => 150, 
                'min_stock' => 300, // Sengaja dibuat di bawah batas minimal
                'unit' => 'Pcs',
                'cost_per_unit' => 800,
                'created_at' => $now, 'updated_at' => $now
            ]
        ]);
    }
}