<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Cart;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_add_item_to_cart()
{
    
    $product = \App\Models\Product::create([
        'Product_name' => 'Test Product',
        'Price' => 100,
        'Available_quantity' => 10,
        'Product_pic' => 'test.jpg',
        'Brand_name' => 'Test Brand',
        'Category_id' => 1,
        'Category_name' => 'Test Category',
    ]);

    
    \App\Models\ProductSize::create([
        'Product_id' => $product->Product_id,
        'Size' => 'M',
        'Quantity' => 10,   
    ]);

    $response = $this->post('/cart/add', [
        'product_id' => $product->Product_id,
        'quantity' => 2,
        'size' => 'M',
    ]);


    $response->assertRedirect();
    $response->assertSessionHas('success', 'Added to cart');

    $this->assertDatabaseHas('cart', [
        'Product_id' => $product->Product_id,
        'Quantity' => 2,
        'Size' => 'M',
    ]);
}
}
