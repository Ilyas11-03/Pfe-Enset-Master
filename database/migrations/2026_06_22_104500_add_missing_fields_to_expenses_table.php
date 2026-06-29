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
        Schema::table('expenses', function (Blueprint $table) {
            // Core fields expected by the app
            $table->string('name')->after('id');
            $table->text('description')->nullable()->after('name');
            $table->string('category')->default('Other')->after('description');
            $table->string('receipt')->nullable()->after('category');

            // Audit fields
            $table->foreignId('created_by')->nullable()->constrained('users')->after('receipt');
            $table->foreignId('updated_by')->nullable()->constrained('users')->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn(['name', 'description', 'category', 'receipt']);
            $table->dropConstrainedForeignId('created_by');
            $table->dropConstrainedForeignId('updated_by');
        });
    }
};
