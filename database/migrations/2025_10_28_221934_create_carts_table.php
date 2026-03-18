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
        Schema::create('Cart', function (Blueprint $table) {
            $table->id('Cart_ID');
            $table->unsignedBigInteger('Customer_ID')->nullable();
            $table->timestamps();

            $table->foreign('Customer_ID')->references('Customer_ID')->on('Customer')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Cart');
    }
};
