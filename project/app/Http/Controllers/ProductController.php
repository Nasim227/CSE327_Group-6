<?php

namespace App\Http\Controllers;

use App\Models\Product;
/**
 * Class ProductController
 *
 * This controller is responsible for showing the list of products to the user.
 * It collects product information from the database and sends it to the view
 * where the products are displayed visually on the webpage.
 *
 * @package App\Http\Controllers
 */
class ProductController
{

        /**
     * Show all products.
     *
     * This method retrieves every product stored in the database and then
     * loads the 'products' view, providing it with the data so that the
     * page can display all available products to the user.
     *
     * @return \Illuminate\View\View The view that presents the full product list.
     */
    public function show_products()
    {
        $products = Product::all();
        return view('products', compact('products'));
    }
}
