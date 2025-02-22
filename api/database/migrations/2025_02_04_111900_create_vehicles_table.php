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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('brand', 50);
            $table->string('model', 50);
            $table->year('year');
            $table->string('vin_number', 17);
            $table->string('register_number', 9);
            $table->integer('milleage');

            $table->unsignedBigInteger('vehicle_categorie_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('vehicle_categorie_id')->references('id')->on('vehicle_categories')->onDelete('RESTRICT');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
