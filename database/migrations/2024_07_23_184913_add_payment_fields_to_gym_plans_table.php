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
            $table->decimal('total_amount', 10, 2)->after('duration');
            $table->decimal('amount_paid', 10, 2)->default(0)->after('total_amount');
            $table->decimal('due_amount', 10, 2)->default(0)->after('amount_paid');
            $table->decimal('discount_amount', 10, 2)->default(0)->nullable()->after('due_amount');
            $table->string('payment_status')->default('Pending')->after('discount_amount');
            $table->string('payment_method')->nullable()->after('payment_status');
            $table->date('due_date')->nullable()->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gym_plans', function (Blueprint $table) {
            $table->dropColumn('total_amount');
            $table->dropColumn('amount_paid');
            $table->dropColumn('due_amount');
            $table->dropColumn('discount_amount');
            $table->dropColumn('payment_status');
            $table->dropColumn('payment_method');
            $table->dropColumn('due_date');
        });
    }
};
