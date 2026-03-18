<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_specifications', function (Blueprint $table) {
            $table->unsignedBigInteger('Product_ID');
            $table->unsignedBigInteger('Spec_ID');
            $table->string('Spec_value', 255)->nullable();

            $table->primary(['Product_ID', 'Spec_ID']);

            $table->foreign('Product_ID')
                  ->references('Product_ID')->on('product')
                  ->onDelete('cascade');

            $table->foreign('Spec_ID')
                  ->references('Spec_ID')->on('specifications')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_specifications');
    }
};
