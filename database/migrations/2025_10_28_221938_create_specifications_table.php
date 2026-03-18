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
        Schema::create('Specifications', function (Blueprint $table) {
            $table->id('Spec_ID');
            $table->string('Spec_name', 100)->nullable();
            $table->timestamps();

          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Specifications');
    }
};
