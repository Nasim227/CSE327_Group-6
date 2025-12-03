<div class="filter-section">
    <form method="GET" action="{{ route('search') }}" id="searchFilterForm">
        {{-- KEEP THE SEARCH QUERY WHEN FILTERING --}}
        <input type="hidden" name="query" value="{{ $search }}">

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
                    >
                </div>
            </div>
        </div>

        {{-- CLEAR FILTERS BUTTON (matches your .clear-filters-btn CSS) --}}
        <button
            type="button"
            class="clear-filters-btn"
            onclick="window.location='{{ route('search', ['query' => $search]) }}'"
        >
            Clear Filters
        </button>
    </form>
</div>

<script>
    // Auto-submit when any filter changes (checkbox or price input)
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('searchFilterForm');
        const inputs = document.querySelectorAll('.filter-input');

        inputs.forEach(input => {
            input.addEventListener('change', function () {
                form.submit();
            });
        });
    });
</script>
