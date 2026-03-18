<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('Product', function (Blueprint $table) {
        $table->id('Product_ID');
        $table->string('Product_name');
        $table->string('Product_image')->nullable();
        $table->decimal('Price', 10, 2);
        $table->integer('Quantity')->default(0);
        $table->unsignedBigInteger('SubCategory_ID')->nullable();
        $table->foreign('SubCategory_ID')->references('SubCategory_ID')->on('Subcategory')->onDelete('set null');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Product');
    }
};
