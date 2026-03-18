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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Product_ID');
            $table->unsignedBigInteger('Customer_ID');
            $table->integer('Rating');
            $table->text('Comment');
            $table->timestamps();

            $table->foreign('Product_ID')->references('Product_ID')->on('Product')->onDelete('cascade');
            $table->foreign('Customer_ID')->references('Customer_ID')->on('Customer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
