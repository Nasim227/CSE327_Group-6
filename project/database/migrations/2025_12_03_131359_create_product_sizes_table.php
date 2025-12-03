<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Product_id');
            $table->string('Size');
            $table->integer('Quantity');
            $table->timestamps();

            $table->foreign('Product_id')
                  ->references('Product_id')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_sizes');
    }
};
