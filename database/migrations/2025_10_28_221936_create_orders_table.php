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
        Schema::create('Orders', function (Blueprint $table) {
            $table->id('Order_ID');
            $table->date('Order_date');
            $table->string('Delivery_address', 255)->nullable();
            $table->string('Order_status', 50)->nullable();
            $table->unsignedBigInteger('Cart_ID');
            $table->timestamps();

            $table->foreign('Cart_ID')->references('Cart_ID')->on('Cart')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Orders');
    }
};
