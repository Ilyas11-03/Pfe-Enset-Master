<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGymPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gym_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gym_id')->constrained('gyms')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('duration');
            $table->enum('status', ['active', 'inactive', 'expired'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gym_plans');
    }
}
