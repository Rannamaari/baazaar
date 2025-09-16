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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('description');
            $table->boolean('is_featured')->default(false)->after('icon');
            $table->integer('featured_rank')->nullable()->after('is_featured');

            // Add unique constraint for featured_rank to ensure no duplicates (excluding nulls)
            $table->unique('featured_rank', 'categories_featured_rank_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique('categories_featured_rank_unique');
            $table->dropColumn(['icon', 'is_featured', 'featured_rank']);
        });
    }
};
