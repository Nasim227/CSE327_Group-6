<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('cart', function (Blueprint $table) {
    $table->id('Cart_id');
    $table->unsignedBigInteger('User_id')->nullable();
    $table->unsignedBigInteger('Product_id');
    $table->string('Size')->default('M');
    $table->integer('Quantity')->default(1);
    $table->decimal('Price', 10,2);
    $table->decimal('Total_price', 10,2);
    
});

    }

    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
