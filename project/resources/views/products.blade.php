<?php
/**
 * Products View
 *
 * This Blade template displays all available products on the website.
 * It receives a collection of products from the controller 
 * each product with its image, name, category, brand, price, available sizes,
 * and stock quantity. Users can select a size, choose the quantity, and add
 * products to the shopping cart.
 *
 * Features include:
 *  - Dynamic size selection based on available stock
 *  - Real-time quantity updates when size changes
 *  - Form submission to add selected product, size, and quantity to the cart
 *  - Link to navigate to the cart page
 *
 * This template ensures a user-friendly interface for browsing and purchasing
 * products.
 *
 * @package Views
 */
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<h1>All Products</h1>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

@foreach ($products as $product)
    <div class="product-card" id="product-{{ $product->Product_id }}">

        <img src="{{ asset('images/' . $product->Product_pic) }}" width="120">

        <h3>{{ $product->Product_name }}</h3>

        <p>Category: {{ $product->Category_name }}</p>
        <p>Brand: {{ $product->Brand_name }}</p>
        <p>Price: {{ $product->Price }} TK</p>

        <label>Select Size:</label>
        <select class="size-select" data-product="{{ $product->Product_id }}">
            @foreach($product->sizes as $size)
                @if($size->Quantity > 0)
                    <option value="{{ $size->Size }}" data-qty="{{ $size->Quantity }}">
                        {{ $size->Size }}
                    </option>
                @endif
            @endforeach
        </select>

        <p>Available Quantity: 
            <span id="avail-{{ $product->Product_id }}">
        {{ $product->sizes->first()->Quantity }}
            </span>
        </p>

        <form method="POST" action="{{ route('cart.add') }}">
            @csrf

            <input type="hidden" name="product_id" value="{{ $product->Product_id }}">
            <input type="hidden" name="size" class="size-field" id="size-field-{{ $product->Product_id }}" value="{{ $product->sizes->first()->Size }}">

            <label>Quantity:</label>
            <select name="quantity" class="qty-select" id="qty-{{ $product->Product_id }}">
                @for($i = 1; $i <= $product->sizes->first()->Quantity; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>

            <button type="submit">Add to Cart</button>
        </form>

    </div>
@endforeach
<a href="{{ route('cart.view') }}">Go to Cart</a>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.size-select').forEach(function(select) {

        select.addEventListener('change', function() {

            let productId = this.getAttribute('data-product');
            let selectedOption = this.options[this.selectedIndex];
            let availableQty = selectedOption.getAttribute('data-qty');
            let selectedSize = this.value;

            // update hidden size field
            document.getElementById('size-field-' + productId).value = selectedSize;

            // update quantity label
            document.getElementById('avail-' + productId).innerText = availableQty;

            // update quantity dropdown
            let qtySelect = document.getElementById('qty-' + productId);
            qtySelect.innerHTML = "";

            for (let i = 1; i <= availableQty; i++) {
                let opt = document.createElement('option');
                opt.value = i;
                opt.text = i;
                qtySelect.add(opt);
            }

        });

    });

});
</script>
</body>
</html>
