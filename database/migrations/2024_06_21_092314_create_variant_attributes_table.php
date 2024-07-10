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
        Schema::create('variant_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_value_id');
            $table->unsignedBigInteger('variant_id');
            $table->timestamps();

            $table->foreign('attribute_value_id')->references('id')->on('attribute_values')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_attributes');
    }
};
