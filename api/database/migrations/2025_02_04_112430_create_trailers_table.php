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
        Schema::create('trailers', function (Blueprint $table) {
            $table->id();
            $table->string('register_number', 9);

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('body_type_id');
            $table->unsignedBigInteger('trailer_type_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->foreign('body_type_id')->references('id')->on('body_types')->onDelete('RESTRICT');
            $table->foreign('trailer_type_id')->references('id')->on('trailer_types')->onDelete('RESTRICT');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trailers');
    }
};
