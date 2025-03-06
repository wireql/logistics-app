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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->date('plan_delivery');
            $table->text('description')->nullable();

            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('task_status_id')->default(1);

            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('RESTRICT');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->foreign('task_status_id')->references('id')->on('task_statuses')->onDelete('RESTRICT');

            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
