<?php
/**
===================================================================
  Sidebar Filter Component — Documentation
===================================================================

PURPOSE:
    Reusable filtering sidebar for both:
        - Product Listing Page
        - Search Results Page

FILTER TYPES SUPPORTED:
    1. Brand Filter     (checkboxes)
    2. Category Filter  (checkboxes or radio buttons)
    3. Price Range      (min_price → max_price)

RECEIVED VARIABLES:
    $brands              (array<string>)
        → List of distinct brands.

    $categories          (array<int>)
        → List of category IDs.

    $selectedBrands      (array<string>)
        → User-selected brand filters.

    $selectedCategories  (array<int>)
        → User-selected category filters.

    $minPrice            (int|null)
    $maxPrice            (int|null)

BEHAVIOR:
    - Auto-submit when filter changes.
    - Clear Filter button resets all fields.
    - Sidebar CSS applied from /public/css/sidebar.css
*/
?>

<div class="filter-section">
    <form method="GET" action="{{ route('products.index') }}" id="filterForm">
        {{-- CATEGORIES --}}
        <div class="filter-section">
            <strong>Categories</strong>

            @foreach($categories as $categoryId)
                <label>
                    <input
                        type="checkbox"
                        class="filter-input"
                        name="categories[]"
                        value="{{ $categoryId }}"
                        {{ in_array($categoryId, $selectedCategories) ? 'checked' : '' }}
                    >
                    <span>Category {{ $categoryId }}</span>
                </label>
            @endforeach
        </div>

        {{-- BRANDS --}}
        <div class="filter-section">
            <strong>Brands</strong>

            @foreach($brands as $brand)
                <label>
                    <input
                        type="checkbox"
                        class="filter-input"
                        name="brands[]"
                        value="{{ $brand }}"
                        {{ in_array($brand, $selectedBrands) ? 'checked' : '' }}
                    >
                    <span>{{ $brand }}</span>
                </label>
            @endforeach
        </div>

        {{-- PRICE RANGE --}}
        <div class="filter-section">
            <strong>Price Range</strong>

            <div class="price-inputs">
                <div class="price-input-group">
                    <label>Min</label>
                    <input
                        type="number"
                        class="filter-input"
                        name="min_price"
                        value="{{ $minPrice }}"
                        min="0"
                        step="100"
                    >
                </div>

                <div class="price-input-group">
                    <label>Max</label>
                    <input
                        type="number"
                        class="filter-input"
                        name="max_price"
                        value="{{ $maxPrice }}"
                        min="0"
                        step="100"
                    >
                </div>
            </div>
        </div>

        {{-- OPTIONAL manual apply button that matches your CSS --}}
        {{--
        <button type="submit">
            Apply Filters
        </button>
        --}}

        {{-- CLEAR FILTERS BUTTON (using your .clear-filters-btn CSS) --}}
        <button
            type="button"
            class="clear-filters-btn"
            onclick="window.location='{{ route('products.index') }}'"
        >
            Clear Filters
        </button>
    </form>
</div>

<script>
    // Auto-submit when any filter changes (checkbox or price input)
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('filterForm');
        const inputs = document.querySelectorAll('.filter-input');

        inputs.forEach(input => {
            input.addEventListener('change', function () {
                form.submit();
            });
        });
    });
</script>
