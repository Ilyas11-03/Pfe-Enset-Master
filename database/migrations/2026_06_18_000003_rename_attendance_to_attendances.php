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
        // Rename 'attendance' to 'attendances' if it exists
        if (Schema::hasTable('attendance')) {
            Schema::rename('attendance', 'attendances');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename back to 'attendance' if needed
        if (Schema::hasTable('attendances')) {
            Schema::rename('attendances', 'attendance');
        }
    }
};
