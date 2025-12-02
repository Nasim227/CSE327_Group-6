<?php

namespace App\Http\Controllers;

use App\Models\Product;


/**
 * Class ProductController
 *
 * Handles all product-related actions in the website.
 * 
 * Responsibilities:
 * - Retrieve all products from the database.
 * - Include related sizes for each product.
 * - Pass products data to the view for display.
 *
 * @package App\Http\Controllers
 */
class ProductController
{

    /**
     * Display a list of all products.
     *
     * Retrieves all products from the database along with their
     * related sizes. The data is then passed to the 'products' view
     * where it can be displayed to the user.
     *
     * @return \Illuminate\View\View Returns the view with the list of products.
     */
    public function show_products()
    {
        $products = Product::with('sizes')->get();;
        return view('products', compact('products'));
    }
}
