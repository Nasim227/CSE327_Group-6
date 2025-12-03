<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Show search results with the same sidebar filters.
     */
    public function index(Request $request)
    {
        // 1) Sidebar data: DISTINCT brands and categories (from products table)
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

        // 2) Read search text and filters
        $search = trim($request->input('query', ''));

        $selectedBrands = (array) $request->input('brands', []);
        $selectedCategories = (array) $request->input('categories', []);

        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // 3) Build query on products table
        $query = Product::query();

        // Text search
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('Product_name', 'LIKE', "%{$search}%")
                  ->orWhere('Brand_name', 'LIKE', "%{$search}%");
            });
        }

        // Brand filter
        if (!empty($selectedBrands)) {
            $query->whereIn('Brand_name', $selectedBrands);
        }

        // Category filter
        if (!empty($selectedCategories)) {
            $query->whereIn('Category_id', $selectedCategories);
        }

        // Price filters
        if ($minPrice !== null && $minPrice !== '') {
            $query->where('Price', '>=', (int) $minPrice);
        }

        if ($maxPrice !== null && $maxPrice !== '') {
            $query->where('Price', '<=', (int) $maxPrice);
        }

        $products = $query->get();

        // 4) Send everything to the search view
        return view('search.index', [
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
