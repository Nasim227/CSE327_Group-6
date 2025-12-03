<?php
/**
===================================================================
  Search Results View — Documentation
===================================================================

PURPOSE:
    Displays results for a user search query.
    Supports filtering by:
        - Brand
        - Category
        - Price Range

RECEIVED VARIABLES:
    $products            (Collection<App\Models\Product>)
        → Filtered search results.

    $brands              (array<string>)
        → Available brands to refine the search.

    $categories          (array<int>)
        → Available category IDs.

    $selectedBrands      (array<string>)
        → Brands selected by the user.

    $selectedCategories  (array<int>)
        → Categories selected by the user.

    $minPrice            (int|null)
        → Minimum allowed price.

    $maxPrice            (int|null)
        → Maximum allowed price.

    $search              (string)
        → The search text entered by the user.

NOTES:
    - Includes the sidebar filter template.
    - Layout matches the product listing page.
    - Highlights the number of matched results.
*/
?>



@extends('layouts.app')

@section('title', 'Search Products')

{{-- Page-specific CSS files for search page (optional) --}}
@section('page_css')
    {{-- If you have separate CSS for search and sidebar: --}}
    <link rel="stylesheet" href="{{ asset('css/prdcts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endsection

@section('content')
    <h1 style="margin-bottom: 15px;">Search Products</h1>

    {{-- TOP SEARCH BAR --}}
    <form action="{{ route('search') }}" method="GET" style="margin-bottom: 15px;">
        <input
            type="text"
            name="query"
            value="{{ $search }}"
            placeholder="Search by product or brand..."
            style="padding: 6px 10px; width: 260px; max-width: 100%;"
        >
        <button type="submit" style="padding: 6px 10px;">Search</button>
    </form>

    <div class="layout" style="display: flex; gap: 20px; align-items: flex-start;">
        {{-- LEFT: SIDEBAR (this is like include("sidebar.php"); in PHP) --}}
        <aside class="sidebar">
            @include('search.search_sidebar')
        </aside>

        {{-- RIGHT: SEARCH RESULTS --}}
        <main class="content" style="flex: 1;">
            @if($products->isEmpty())
                <p>No products found for your search/filters.</p>
            @else
                <h3 style="margin-bottom: 10px;">
                    Showing {{ $products->count() }} result(s)
                </h3>

                <div class="product-container" style="display:flex; flex-wrap:wrap; gap:15px;">
                    @foreach($products as $product)
                        <div class="product-card" style="border:1px solid #eee; padding:10px; border-radius:4px; width:200px;">
                            <div style="text-align:center; margin-bottom:8px;">
                                @if(!empty($product->Product_pic))
                                    <img
                                        src="{{ asset('images/'.$product->Product_pic) }}"
                                        alt="{{ $product->Product_name }}"
                                        style="max-width:100%; max-height:120px; object-fit:cover;"
                                    >
                                @else
                                    <div style="height:120px; display:flex; align-items:center; justify-content:center; background:#f9f9f9; color:#aaa;">
                                        No Image
                                    </div>
                                @endif
                            </div>

                            <div style="font-weight:bold;">
                                {{ $product->Product_name }}
                            </div>

                            <div style="color:#27ae60; font-weight:bold; margin:4px 0;">
                                Tk {{ $product->Price }}
                            </div>

                            <div style="font-size:12px; color:#666;">
                                Brand: {{ $product->Brand_name }}
                            </div>

                            <div style="font-size:12px; color:#666;">
                                Category ID: {{ $product->Category_id }}
                            </div>

                            <div style="font-size:12px; color:#666;">
                                Available: {{ $product->Available_quantity }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
@endsection
