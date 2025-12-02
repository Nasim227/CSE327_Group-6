<?php
/**
 * Cart View
 *
 * This Blade template displays the contents of the user's shopping cart.
 * It receives a collection of cart items from the controller and renders
 * each item with its product image, name, selected size, unit price,
 * quantity, and total price. Users can adjust the quantity, remove items,
 * and proceed to confirm their order.
 *
 * Features include:
 *  - Increment and decrement quantity for each cart item
 *  - Remove individual items from the cart
 *  - Display of total price per item and grand total
 *  - make order from cart
 *  - Display of success/error messages from session flash data
 *  - Link to return to the products page
 *
 * This template ensures a clear and interactive interface for reviewing
 * and managing items before placing an order.
 *
 * @package Views
 */
?>


<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
</head>
<body>

<h1>Your Cart</h1>

@if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif
@if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif

@foreach ($cartItems as $item)
    <div class="cart-item">


        <img src="{{ asset('images/' . $item->product->Product_pic) }}" width="100">

        <h3>{{ $item->product->Product_name }}</h3>

        <p>Size: {{ $item->Size }}</p>
        <p>Price (Unit): ${{ $item->product->Price }}</p>

        <p>
            Quantity: 
            <form action="{{ route('cart.decrease', $item->Cart_id) }}" method="POST" style="display:inline">
                @csrf
                <button>-</button>
            </form>

            {{ $item->Quantity }}

            <form action="{{ route('cart.increase', $item->Cart_id) }}" method="POST" style="display:inline">
                @csrf
                <button>+</button>
            </form>
        </p>

        <p>Total Price: ${{ $item->Total_price }}</p>

        <form action="{{ route('cart.remove', $item->Cart_id) }}" method="POST">
            @csrf
            <button style="color:red;">Remove Item</button>
        </form>

    </div>
@endforeach

<form action="{{ route('cart.order') }}" method="POST">
    @csrf
    <button style="padding:10px; background:blue; color:white;">
        Confirm Order
    </button>
</form>


<h2>Grand Total: ${{ $grandTotal }}</h2>

<a href="/">Back to Products</a>

</body>
</html>

