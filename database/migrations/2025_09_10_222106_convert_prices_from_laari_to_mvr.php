<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Convert products table prices from laari to MVR
        Schema::table('products', function (Blueprint $table) {
            // First, convert existing data from laari to MVR
            DB::statement('UPDATE products SET price = price / 100 WHERE price > 0');
            DB::statement('UPDATE products SET compare_at_price = compare_at_price / 100 WHERE compare_at_price > 0');

            // Change column types to decimal
            $table->decimal('price', 10, 2)->change();
            $table->decimal('compare_at_price', 10, 2)->nullable()->change();
        });

        // Convert order_items table prices from laari to MVR
        Schema::table('order_items', function (Blueprint $table) {
            // Convert existing data from laari to MVR
            DB::statement('UPDATE order_items SET unit_price = unit_price / 100 WHERE unit_price > 0');
            DB::statement('UPDATE order_items SET line_total = line_total / 100 WHERE line_total > 0');

            // Change column types to decimal
            $table->decimal('unit_price', 10, 2)->change();
            $table->decimal('line_total', 10, 2)->change();
        });

        // Convert orders table prices from laari to MVR
        Schema::table('orders', function (Blueprint $table) {
            // Convert existing data from laari to MVR
            DB::statement('UPDATE orders SET subtotal = subtotal / 100 WHERE subtotal > 0');
            DB::statement('UPDATE orders SET discount_total = discount_total / 100 WHERE discount_total > 0');
            DB::statement('UPDATE orders SET tax_total = tax_total / 100 WHERE tax_total > 0');
            DB::statement('UPDATE orders SET shipping_total = shipping_total / 100 WHERE shipping_total > 0');
            DB::statement('UPDATE orders SET grand_total = grand_total / 100 WHERE grand_total > 0');

            // Change column types to decimal
            $table->decimal('subtotal', 10, 2)->default(0)->change();
            $table->decimal('discount_total', 10, 2)->default(0)->change();
            $table->decimal('tax_total', 10, 2)->default(0)->change();
            $table->decimal('shipping_total', 10, 2)->default(0)->change();
            $table->decimal('grand_total', 10, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert back from MVR to laari
        Schema::table('products', function (Blueprint $table) {
            // Convert data back to laari
            DB::statement('UPDATE products SET price = price * 100 WHERE price > 0');
            DB::statement('UPDATE products SET compare_at_price = compare_at_price * 100 WHERE compare_at_price > 0');

            // Change column types back to integer
            $table->unsignedInteger('price')->change();
            $table->unsignedInteger('compare_at_price')->nullable()->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            // Convert data back to laari
            DB::statement('UPDATE order_items SET unit_price = unit_price * 100 WHERE unit_price > 0');
            DB::statement('UPDATE order_items SET line_total = line_total * 100 WHERE line_total > 0');

            // Change column types back to integer
            $table->unsignedInteger('unit_price')->change();
            $table->unsignedInteger('line_total')->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            // Convert data back to laari
            DB::statement('UPDATE orders SET subtotal = subtotal * 100 WHERE subtotal > 0');
            DB::statement('UPDATE orders SET discount_total = discount_total * 100 WHERE discount_total > 0');
            DB::statement('UPDATE orders SET tax_total = tax_total * 100 WHERE tax_total > 0');
            DB::statement('UPDATE orders SET shipping_total = shipping_total * 100 WHERE shipping_total > 0');
            DB::statement('UPDATE orders SET grand_total = grand_total * 100 WHERE grand_total > 0');

            // Change column types back to integer
            $table->unsignedInteger('subtotal')->default(0)->change();
            $table->unsignedInteger('discount_total')->default(0)->change();
            $table->unsignedInteger('tax_total')->default(0)->change();
            $table->unsignedInteger('shipping_total')->default(0)->change();
            $table->unsignedInteger('grand_total')->default(0)->change();
        });
    }
};
