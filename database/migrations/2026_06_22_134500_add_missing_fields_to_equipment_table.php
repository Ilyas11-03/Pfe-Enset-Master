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
        Schema::table('equipment', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->after('image');
            $table->decimal('amount', 10, 2)->default(0)->after('quantity');
            $table->date('purchase_date')->nullable()->after('amount');
            $table->string('condition')->nullable()->after('purchase_date');
            $table->date('maintenance_date')->nullable()->after('condition');
            $table->string('serial_number')->nullable()->after('maintenance_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'amount', 'purchase_date', 'condition', 'maintenance_date', 'serial_number']);
        });
    }
};
