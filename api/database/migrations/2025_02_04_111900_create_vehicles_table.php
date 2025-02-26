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
            $table->decimal('max_volume');
            $table->decimal('max_weight');

            $table->unsignedBigInteger('vehicle_status_id');
            $table->unsignedBigInteger('vehicle_category_id');
            $table->unsignedBigInteger('body_type_id');
            $table->unsignedBigInteger('company_id');

            $table->foreign('vehicle_status_id')->references('id')->on('vehicle_statuses')->onDelete('RESTRICT');
            $table->foreign('vehicle_category_id')->references('id')->on('vehicle_categories')->onDelete('RESTRICT');
            $table->foreign('body_type_id')->references('id')->on('body_types')->onDelete('RESTRICT');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');

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
