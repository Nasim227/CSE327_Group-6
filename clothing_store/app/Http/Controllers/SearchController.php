<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Class SearchController
 *
 * Handles product search functionality in the clothing store system.
 *
 * This controller:
 * - Accepts a free-text search query (product name or brand).
 * - Applies the same sidebar filters as the products page
 *   (brand, category, and price range).
 * - Returns a dedicated search results page.
 *
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{
    /**
     * Display search results for products with optional filters.
     *
     * Supported query parameters:
     * - query           : text to search in Product_name and Brand_name
     * - brands[]        : array of brand names
     * - categories[]    : array of category IDs
     * - min_price       : minimum price (inclusive)
     * - max_price       : maximum price (inclusive)
     *
     * View: resources/views/search/index.blade.php
     *
     * @param \Illuminate\Http\Request $request
     *     The incoming search request containing the query and filters.
     *
     * @return \Illuminate\View\View
     *     The rendered search results page.
     */
    public function index(Request $request)
    {
        // 1) Sidebar data: distinct brands and categories from products table
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

        // 2) Read search text and filters from the request
        $search = trim($request->input('query', ''));

        $selectedBrands = (array) $request->input('brands', []);
        $selectedCategories = (array) $request->input('categories', []);

        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // 3) Build product query with search + filters
        $query = Product::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('Product_name', 'LIKE', "%{$search}%")
                  ->orWhere('Brand_name', 'LIKE', "%{$search}%");
            });
        }

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

        // 4) Execute query
        $products = $query->get();

        // 5) Return the search results view with all variables needed by Blade
        return view('search.search_index', [
            'brands'             => $brands,
            'categories'         => $categories,
            'products'           => $products,
            'selectedBrands'     => $selectedBrands,
            'selectedCategories' => $selectedCategories,
            'minPrice'           => $minPrice,
            'maxPrice'           => $maxPrice,
            'search'             => $search,
        ]);
    }
}
