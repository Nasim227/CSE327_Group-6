<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up(): void
    {
Schema::create('products', function (Blueprint $table) {
    $table->id('Product_id'); // primary key

$table->unsignedBigInteger('Category_id')->nullable(); // allow NULL
$table->string('Category_name')->nullable(); // allow NULL

    $table->string('Product_name');
    $table->string('Brand_name')->nullable();
    $table->decimal('Price', 10, 2);
    $table->integer('Available_quantity')->default(0); // corrected spelling
    $table->string('Product_pic')->nullable();
    $table->string('Brand_logo')->nullable();
    $table->string('Size')->nullable();

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}

