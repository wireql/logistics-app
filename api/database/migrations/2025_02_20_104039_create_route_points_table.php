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
        Schema::create('route_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('address_from_id');
            $table->unsignedBigInteger('address_to_id');
            $table->date('plan_delivery');
            $table->uuid('route_list_id');
            $table->unsignedBigInteger('route_point_status_id')->default(1);
            $table->timestamps();

            $table->foreign('address_from_id')->references('id')->on('addresses')->onDelete('RESTRICT');
            $table->foreign('address_to_id')->references('id')->on('addresses')->onDelete('RESTRICT');
            $table->foreign('route_list_id')->references('id')->on('route_lists')->onDelete('RESTRICT');
            $table->foreign('route_point_status_id')->references('id')->on('route_point_statuses')->onDelete('RESTRICT');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_points');
    }
};
