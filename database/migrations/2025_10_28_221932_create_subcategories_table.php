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
        Schema::create('Subcategory', function (Blueprint $table) {
            $table->id('SubCategory_ID');
            $table->string('SubCategory_name', 100);
            $table->unsignedBigInteger('Category_ID')->nullable();
            $table->timestamps();

            $table->foreign('Category_ID')->references('Category_ID')->on('Category')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Subcategory');
    }
};
