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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_status')->default('pending')->after('payment_method');
            $table->string('payment_slip_path')->nullable()->after('payment_status');
            $table->text('delivery_address')->nullable()->after('payment_slip_path');
            $table->string('delivery_phone')->nullable()->after('delivery_address');
            $table->text('admin_notes')->nullable()->after('delivery_phone');
            $table->timestamp('payment_verified_at')->nullable()->after('admin_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'payment_slip_path',
                'delivery_address',
                'delivery_phone',
                'admin_notes',
                'payment_verified_at',
            ]);
        });
    }
};
