<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show product list with sidebar filters (categories + brands).
     */
    public function index(Request $request)
{
    // 1) Sidebar data: DISTINCT brands and categories
    $brands = Product::select('Brand_name')
        ->whereNotNull('Brand_name')
        ->where('Brand_name', '!=', '')
        ->distinct()
        ->orderBy('Brand_name')
        ->pluck('Brand_name')
        ->toArray();

    $categories = Product::select('Category_id')
        ->distinct()
        ->orderBy('Category_id')
        ->pluck('Category_id')
        ->toArray();

    // 2) Read selected filters from the request
    $selectedBrands = (array) $request->input('brands', []);
    $selectedCategories = (array) $request->input('categories', []);

    // Price range (can be empty)
    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');

    // 3) Build product query with filters
    $query = Product::query();

    if (!empty($selectedBrands)) {
        $query->whereIn('Brand_name', $selectedBrands);
    }

    if (!empty($selectedCategories)) {
        $query->whereIn('Category_id', $selectedCategories);
    }

    if ($minPrice !== null && $minPrice !== '') {
        $query->where('Price', '>=', (int) $minPrice);
    }

    if ($maxPrice !== null && $maxPrice !== '') {
        $query->where('Price', '<=', (int) $maxPrice);
    }

    $products = $query->get();

    // 4) Pass everything to the view
    return view('products.index', [
        'brands'             => $brands,
        'categories'         => $categories,
        'products'           => $products,
        'selectedBrands'     => $selectedBrands,
        'selectedCategories' => $selectedCategories,
        'minPrice'           => $minPrice,
        'maxPrice'           => $maxPrice,
    ]);
}

}
