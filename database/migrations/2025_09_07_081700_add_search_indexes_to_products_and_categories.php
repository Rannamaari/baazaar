<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes to products table for better search performance
        Schema::table('products', function (Blueprint $table) {
            $table->index(['name', 'is_active'], 'products_name_active_index');
            $table->index(['category_id', 'is_active'], 'products_category_active_index');
            $table->index(['slug', 'is_active'], 'products_slug_active_index');
            $table->index('is_active', 'products_is_active_index');
            $table->index('created_at', 'products_created_at_index');
        });

        // Add indexes to categories table for better performance
        Schema::table('categories', function (Blueprint $table) {
            $table->index(['name', 'is_active'], 'categories_name_active_index');
            $table->index(['slug', 'is_active'], 'categories_slug_active_index');
            $table->index('is_active', 'categories_is_active_index');
            $table->index(['is_featured', 'featured_rank'], 'categories_featured_rank_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes from products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_name_active_index');
            $table->dropIndex('products_category_active_index');
            $table->dropIndex('products_slug_active_index');
            $table->dropIndex('products_is_active_index');
            $table->dropIndex('products_created_at_index');
        });

        // Drop indexes from categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_name_active_index');
            $table->dropIndex('categories_slug_active_index');
            $table->dropIndex('categories_is_active_index');
            $table->dropIndex('categories_featured_rank_index');
        });
    }
};
