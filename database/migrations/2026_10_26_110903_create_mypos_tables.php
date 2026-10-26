<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update Users Table
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'kasir'])->default('kasir');
            $table->boolean('is_active')->default(true);
        });

        // 2. Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable(); 
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 3. Menus
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2);
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 4. Tables
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('capacity')->default(2);
            $table->enum('status', ['available', 'occupied'])->default('available');
            $table->integer('pos_x')->default(0);
            $table->integer('pos_y')->default(0);
            $table->timestamps();
        });

        // 5. Suppliers
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 6. Ingredients
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->string('name');
            $table->string('unit');
            $table->decimal('stock', 10, 2)->default(0);
            $table->decimal('min_stock', 10, 2)->default(0);
            $table->decimal('cost_per_unit', 15, 2)->default(0);
            $table->timestamps();
        });

        // 7. Inventory Movements
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')->constrained('ingredients')->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->enum('type', ['in', 'out', 'adjustment']);
            $table->decimal('quantity', 10, 2);
            $table->decimal('cost_per_unit', 15, 2)->nullable();
            $table->text('notes')->nullable();
            $table->date('movement_date');
            $table->timestamps();
        });

        // 8. Menu Ingredients
        Schema::create('menu_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->foreignId('ingredient_id')->constrained('ingredients')->onDelete('cascade');
            $table->decimal('quantity_used', 10, 2);
            $table->timestamps();
        });

        // 9. Transactions
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('table_id')->nullable()->constrained('tables')->nullOnDelete();
            $table->enum('order_type', ['dine_in', 'takeaway']);
            $table->enum('status', ['open', 'hold', 'paid', 'cancelled'])->default('open');
            $table->enum('payment_method', ['cash', 'transfer', 'qris'])->nullable();
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('tax', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('change_amount', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        // 10. Transaction Items
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->foreignId('menu_id')->nullable()->constrained('menus')->nullOnDelete();
            $table->string('menu_name');
            $table->decimal('price', 15, 2);
            $table->integer('quantity');
            $table->decimal('subtotal', 15, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 11. Settings
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // 12. Printer Settings
        Schema::create('printer_settings', function (Blueprint $table) {
            $table->id();
            $table->string('printer_name');
            $table->string('printer_type');
            $table->boolean('auto_print')->default(true);
            $table->string('paper_size')->default('58mm');
            $table->string('header_text')->nullable();
            $table->string('footer_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('printer_settings');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('transaction_items');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('menu_ingredients');
        Schema::dropIfExists('inventory_movements');
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('tables');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('categories');
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_active']);
        });
    }
};