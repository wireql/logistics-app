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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('email', 100);
            $table->string('password');
            
            $table->unsignedBigInteger('employee_categorie_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('employee_categorie_id')->references('id')->on('employee_categories')->onDelete('RESTRICT');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
