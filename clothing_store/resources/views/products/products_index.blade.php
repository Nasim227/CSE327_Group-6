<?php
/**
=================================================================
  Products Index View — Documentation
=================================================================

PURPOSE:
    This page displays the full list of products in the clothing store.
    It also integrates the sidebar filtering system (brand, category, price).

RECEIVED VARIABLES:
    $products            (Collection<App\Models\Product>)
        → List of products after applying filters.

    $brands              (array<string>)
        → Distinct list of available brands for the sidebar.

    $categories          (array<int>)
        → Distinct list of category IDs for filtering.

    $selectedBrands      (array<string>)
        → Brands currently selected in the filter.

    $selectedCategories  (array<int>)
        → Categories currently selected in the filter.

    $minPrice            (int|null)
        → Minimum price filter value.

    $maxPrice            (int|null)
        → Maximum price filter value.

NOTES:
    - Uses the shared sidebar component: resources/views/components/sidebar.blade.php
    - Applies filters automatically when the form changes.
    - Displays product cards in a 3-column grid.
*/
?>


@extends('layouts.app')

@section('title', 'Products')

{{-- If you want the same sidebar styling on products page too --}}
@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endsection

@section('content')
    <h1 style="margin-bottom: 15px;">All Products</h1>

    <div class="layout">
        {{-- LEFT SIDEBAR (same as products filter sidebar) --}}
        <aside class="sidebar">
            @include('products.products_sidebar')
        </aside>

        {{-- RIGHT CONTENT --}}
        <main class="content">
            @if($products->isEmpty())
                <p>No products available.</p>
            @else
                <div class="product-container">
                    @foreach($products as $product)
                        <div class="product-card">
                            <div style="text-align:center; margin-bottom:8px;">
                                @if(!empty($product->Product_pic))
                                    <img
                                        src="{{ asset('images/'.$product->Product_pic) }}"
                                        alt="{{ $product->Product_name }}"
                                    >
                                @else
                                    <div style="height:120px; display:flex; align-items:center; justify-content:center; background:#f9f9f9; color:#aaa;">
                                        No Image
                                    </div>
                                @endif
                            </div>

                            <div class="product-card-title">
                                {{ $product->Product_name }}
                            </div>

                            <div class="product-card-price">
                                Tk {{ $product->Price }}
                            </div>

                            <div class="product-card-meta">
                                Brand: {{ $product->Brand_name }}<br>
                                Category ID: {{ $product->Category_id }}<br>
                                Available: {{ $product->Available_quantity }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
@endsection
