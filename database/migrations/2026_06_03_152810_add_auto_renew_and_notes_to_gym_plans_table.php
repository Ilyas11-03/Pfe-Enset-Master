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
        Schema::table('gym_plans', function (Blueprint $table) {
            $table->boolean('auto_renew')->default(false);
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gym_plans', function (Blueprint $table) {
            $table->dropColumn(['auto_renew', 'notes']);
        });
    }
};
