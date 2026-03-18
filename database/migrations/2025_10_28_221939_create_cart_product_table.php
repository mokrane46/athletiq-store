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
        Schema::create('Cart_Product', function (Blueprint $table) {
            $table->unsignedBigInteger('Cart_ID');
            $table->unsignedBigInteger('Product_ID');
            $table->integer('Product_quantity')->default(1);
            $table->timestamps();

            $table->primary(['Cart_ID', 'Product_ID']);
            $table->foreign('Cart_ID')->references('Cart_ID')->on('Cart')->onDelete('cascade');
            $table->foreign('Product_ID')->references('Product_ID')->on('Product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Cart_Product');
    }
};
