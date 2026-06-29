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
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('membership_id')->nullable()->constrained('memberships')->nullOnDelete()->after('member_id');
            $table->date('start_date')->nullable()->after('sport_id');
            $table->decimal('amount_paid', 10, 2)->default(0)->after('total_amount');
            $table->decimal('due_amount', 10, 2)->default(0)->after('amount_paid');
            $table->string('payment_status')->default('Pending')->after('due_amount');
            $table->boolean('auto_renew')->default(false)->after('payment_status');
            $table->text('notes')->nullable()->after('auto_renew');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('membership_id');
            $table->dropColumn([
                'start_date',
                'amount_paid',
                'due_amount',
                'payment_status',
                'auto_renew',
                'notes',
            ]);
        });
    }
};
