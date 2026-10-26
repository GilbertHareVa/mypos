<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Buat 5 Users (1 Admin, 4 Kasir)
        DB::table('users')->insert([
            ['name' => 'Admin Utama', 'email' => 'admin@mypos.com', 'password' => Hash::make('password'), 'role' => 'admin', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kasir Satu', 'email' => 'kasir@mypos.com', 'password' => Hash::make('password'), 'role' => 'kasir', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kasir Dua', 'email' => 'kasir2@mypos.com', 'password' => Hash::make('password'), 'role' => 'kasir', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kasir Tiga', 'email' => 'kasir3@mypos.com', 'password' => Hash::make('password'), 'role' => 'kasir', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kasir Empat', 'email' => 'kasir4@mypos.com', 'password' => Hash::make('password'), 'role' => 'kasir', 'is_active' => false, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 2. Buat 7 Kategori
        $categories = ['Semua', 'Minuman', 'Makanan', 'Snack', 'Dessert', 'Kopi', 'Jus & Smoothie'];
        $categoryId = 1;
        foreach ($categories as $cat) {
            DB::table('categories')->insert([
                'id' => $categoryId++,
                'name' => $cat,
                'slug' => strtolower(str_replace([' & ', ' '], ['-', '-'], $cat)),
                'sort_order' => $categoryId,
                'created_at' => $now, 'updated_at' => $now
            ]);
        }

        // 3. Buat 55+ Menus Otomatis dengan Gambar Unsplash
        $menus = [];
        $kopiNames = ['Espresso', 'Americano', 'Cappuccino', 'Latte', 'Cold Brew', 'Mocha', 'Macchiato', 'Flat White', 'Affogato', 'Irish Coffee', 'Frappe', 'Piccolo', 'Cortado', 'Vienna', 'Nitro Coffee'];
        $makananNames = ['Nasi Goreng', 'Pasta Carbonara', 'Beef Burger', 'Club Sandwich', 'Ayam Bakar', 'Mie Goreng', 'Steak', 'Salad', 'Pizza', 'Sop Iga', 'Sate Ayam', 'Fish and Chips'];
        
        $menuId = 1;
        // Generate Kopi (15 item)
        foreach ($kopiNames as $index => $nama) {
            $menus[] = ['id' => $menuId++, 'category_id' => 6, 'name' => $nama, 'price' => 20000 + ($index * 1000), 'image' => 'https://images.unsplash.com/photo-1497935586351-b67a49e012bf?w=400&h=300&fit=crop&auto=format', 'created_at' => $now, 'updated_at' => $now];
        }
        // Generate Makanan (12 item)
        foreach ($makananNames as $index => $nama) {
            $menus[] = ['id' => $menuId++, 'category_id' => 3, 'name' => $nama, 'price' => 35000 + ($index * 2000), 'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&h=300&fit=crop&auto=format', 'created_at' => $now, 'updated_at' => $now];
        }
        // Generate dummy sisa menu untuk mencapai 55 item
        for($i=1; $i<=28; $i++) {
            $menus[] = ['id' => $menuId++, 'category_id' => rand(2, 7), 'name' => 'Menu Spesial ' . $i, 'price' => 25000, 'image' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&h=300&fit=crop&auto=format', 'created_at' => $now, 'updated_at' => $now];
        }
        DB::table('menus')->insert($menus);

        // 4. Buat 15 Meja
        $tables = [];
        for ($i = 1; $i <= 10; $i++) { $tables[] = ['name' => 'Meja ' . $i, 'capacity' => 4, 'created_at' => $now, 'updated_at' => $now]; }
        for ($i = 1; $i <= 2; $i++) { $tables[] = ['name' => 'Bar ' . $i, 'capacity' => 2, 'created_at' => $now, 'updated_at' => $now]; }
        for ($i = 1; $i <= 2; $i++) { $tables[] = ['name' => 'VIP ' . $i, 'capacity' => 8, 'created_at' => $now, 'updated_at' => $now]; }
        $tables[] = ['name' => 'Outdoor', 'capacity' => 6, 'created_at' => $now, 'updated_at' => $now];
        DB::table('tables')->insert($tables);

        // 5. Pengaturan Dasar Cafe
        DB::table('settings')->insert([
            ['key' => 'cafe_name', 'value' => 'MyPOS Cafe', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'cafe_address', 'value' => 'Jl. Kopi Harum No. 123, Jakarta', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'cafe_phone', 'value' => '081234567890', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'tax_percentage', 'value' => '10', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'cafe_tagline', 'value' => 'Secangkir Semangat Setiap Hari', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}