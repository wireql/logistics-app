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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('country', 100);
            $table->string('region', 100);
            $table->string('city', 100);
            $table->string('street', 100);
            $table->string('building', 20);
            $table->string('flat', 20)->nullable()->default(null);
            $table->decimal('latitude', 9, 6)->nullable()->default(null);
            $table->decimal('longitude', 9, 6)->nullable()->default(null);
            $table->timestamps();

            $table->unsignedBigInteger('address_category_id');
            $table->unsignedBigInteger('company_id');

            $table->foreign('address_category_id')->references('id')->on('address_categories')->onDelete('RESTRICT');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
