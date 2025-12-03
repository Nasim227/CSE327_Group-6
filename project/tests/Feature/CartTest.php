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

    /**
     * @test
     */
    public function user_cannot_add_more_than_stock()
    {
        
        $product = \App\Models\Product::create([
            'Product_name' => 'Test Product',
            'Price' => 100,
            'Available_quantity' => 5,  
            'Product_pic' => 'test.jpg',
            'Brand_name' => 'Test Brand',
            'Category_id' => 1,
            'Category_name' => 'Test Category',
        ]);

        
        \App\Models\ProductSize::create([
            'Product_id' => $product->Product_id,
            'Size' => 'M',
            'Quantity' => 5,
        ]);

        
        $response = $this->post('/cart/add', [
            'product_id' => $product->Product_id,
            'quantity' => 10,  
            'size' => 'M',
        ]);

        
        $response->assertRedirect();
        $response->assertSessionHas('error', 'Not enough stock for selected size!');

        
        $this->assertDatabaseMissing('cart', [
            'Product_id' => $product->Product_id,
            'Size' => 'M',
        ]);
    }


    /**
     * @test
     */
    public function user_can_increase_cart_quantity()
    {
    
        $product = \App\Models\Product::create([
            'Product_name' => 'Test Product',
            'Price' => 100,
            'Available_quantity' => 5,
            'Product_pic' => 'test.jpg',
            'Brand_name' => 'Test Brand',
            'Category_id' => 1,
            'Category_name' => 'Test Category',
        ]);

        \App\Models\ProductSize::create([
            'Product_id' => $product->Product_id,
            'Size' => 'M',
            'Quantity' => 5,
        ]);

        
        $cart = \App\Models\Cart::create([
            'User_id' => null,
            'Product_id' => $product->Product_id,
            'Size' => 'M',
            'Quantity' => 2,
            'Price' => $product->Price,
            'Total_price' => $product->Price * 2,
        ]);

    
        $response = $this->post("/cart/increase/{$cart->Cart_id}");

    
        $this->assertDatabaseHas('cart', [
            'Cart_id' => $cart->Cart_id,
            'Quantity' => 3,
            'Total_price' => $product->Price * 3,
        ]);
    }

    /**
     * @test
     */
    public function cart_displays_correct_grand_total()
    {
    
        $product1 = \App\Models\Product::create([
            'Product_name' => 'Product 1',
            'Price' => 100,
            'Available_quantity' => 10,
            'Product_pic' => 'p1.jpg',
            'Brand_name' => 'Brand 1',
            'Category_id' => 1,
            'Category_name' => 'Cat 1',
        ]);

        $product2 = \App\Models\Product::create([
            'Product_name' => 'Product 2',
            'Price' => 200,
            'Available_quantity' => 5,
            'Product_pic' => 'p2.jpg',
            'Brand_name' => 'Brand 2',
            'Category_id' => 1,
            'Category_name' => 'Cat 1',
        ]);

        \App\Models\ProductSize::create([
            'Product_id' => $product1->Product_id,
            'Size' => 'M',
            'Quantity' => 10,
        ]);

        \App\Models\ProductSize::create([
            'Product_id' => $product2->Product_id,
            'Size' => 'L',
            'Quantity' => 5,
        ]);

        
        \App\Models\Cart::create([
            'User_id' => null,
            'Product_id' => $product1->Product_id,
            'Size' => 'M',
            'Quantity' => 2,
            'Price' => $product1->Price,
            'Total_price' => $product1->Price * 2,
        ]);

        \App\Models\Cart::create([
            'User_id' => null,
            'Product_id' => $product2->Product_id,
            'Size' => 'L',
            'Quantity' => 1,
            'Price' => $product2->Price,
            'Total_price' => $product2->Price * 1,
        ]);

    
        $controller = new \App\Http\Controllers\CartController();
        $response = $controller->viewCart();

    
        $grandTotal = $response->getData()['grandTotal'];

    
        $expectedTotal = (2 * 100) + (1 * 200); 
        $this->assertEquals($expectedTotal, $grandTotal);
    }
}
