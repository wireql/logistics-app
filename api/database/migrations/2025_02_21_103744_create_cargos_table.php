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
        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->string('barcode', 10);
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('weight');
            $table->decimal('volume');
            $table->timestamps();

            $table->unsignedBigInteger('route_point_id');
            $table->foreign('route_point_id')->references('id')->on('route_points')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos');
    }
};
