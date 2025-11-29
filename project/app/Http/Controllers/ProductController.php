<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show_products()
    {
        $products = Product::all();
        return view('products', compact('products'));
    }
}
