<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Class ProductController
 *
 * Handles listing products on the main products page with
 * sidebar-based filtering (brand, category, and price range).
 *
 * This controller is responsible for:
 * - Loading distinct brands and categories for the sidebar filters.
 * - Reading selected filters from the HTTP request.
 * - Building a filtered Eloquent query on the products table.
 * - Returning the products.index Blade view with all required data.
 *
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    /**
     * Display the main product listing with optional filters.
     *
     * Supported filters (from the request):
     * - brands[]        : array of brand names to include
     * - categories[]    : array of category IDs to include
     * - min_price       : minimum price (inclusive)
     * - max_price       : maximum price (inclusive)
     *
     * View: resources/views/products/index.blade.php
     *
     * @param \Illuminate\Http\Request $request
     *     The incoming HTTP request containing optional filter values.
     *
     * @return \Illuminate\View\View
     *     The rendered product listing page.
     */
    public function index(Request $request)
    {
        // 1) Load sidebar data: distinct brands and categories from the products table
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

        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // 3) Build a filtered product query
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

        // 4) Execute query and retrieve products
        $products = $query->get();

        // 5) Return view with all data needed by the Blade template
        return view('products.products_index', [
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
