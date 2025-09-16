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
        Schema::table('addresses', function (Blueprint $table) {
            // Add new columns for Maldives address system
            $table->string('type')->default('home')->after('user_id'); // 'home' or 'office'
            $table->string('street_address')->after('label'); // Rename line1 to street_address
            $table->string('road_name')->nullable()->after('street_address'); // Rename line2 to road_name
            $table->string('atoll')->after('island'); // Add atoll field
            $table->text('additional_notes')->nullable()->after('postal_code'); // Add additional notes

            // Add indexes
            $table->index(['user_id', 'type']);
            $table->index(['user_id', 'is_default']);
        });

        // Migrate existing data
        DB::statement("
            UPDATE addresses 
            SET 
                type = 'home',
                street_address = line1,
                road_name = line2,
                atoll = 'Kaafu',
                additional_notes = NULL
            WHERE street_address IS NULL
        ");

        // Drop old columns
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn(['line1', 'line2', 'city']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            // Add back old columns
            $table->string('line1')->after('label');
            $table->string('line2')->nullable()->after('line1');
            $table->string('city')->after('line2');

            // Drop new columns
            $table->dropColumn([
                'type',
                'street_address',
                'road_name',
                'atoll',
                'additional_notes',
            ]);

            // Drop indexes
            $table->dropIndex(['user_id', 'type']);
            $table->dropIndex(['user_id', 'is_default']);
        });
    }
};
