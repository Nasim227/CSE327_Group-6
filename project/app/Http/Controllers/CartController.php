<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Class CartController
 *
 * Handles all actions related to the shopping cart on the website.
 * 
 * This includes adding products to the cart, viewing items, updating
 * quantities, removing items, and confirming orders.
 * All methods ensure stock availability and maintain consistency with
 * the Product and ProductSize models.
 *
 * @package App\Http\Controllers
 */
class CartController 
{
    /**
     * Add a product to the shopping cart.
     *
     * This method adds a product of a specific size and quantity to the cart.
     * If the product with the selected size already exists in the cart, it
     * increases the quantity without exceeding the available stock.
     * Returns a success message if the item is added, or an error if the
     * selected size is out of stock or the requested quantity is too high.
     *
     * @param Request $request Contains 'product_id', 'size', and 'quantity' from the user.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the cart page with a message.
     */
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $sizeStock = \App\Models\ProductSize::where('Product_id', $product->Product_id)
                                            ->where('Size', $request->size)
                                            ->first();

        if (!$sizeStock || $sizeStock->Quantity <= 0) {
            return back()->with('error', 'This size is out of stock!');
        }

        if ($request->quantity > $sizeStock->Quantity) {
            return back()->with('error', 'Not enough stock for selected size!');
        }

        $existing = Cart::where('Product_id', $product->Product_id)
                        ->where('Size', $request->size)
                        ->first();

        if ($existing) {
            $newQty = $existing->Quantity + $request->quantity;

            if ($newQty > $sizeStock->Quantity) {
                return back()->with('error', 'Not enough stock!');
            }

            $existing->update([
                'Quantity' => $newQty,
                'Total_price' => $newQty * $product->Price,
            ]);
        } else {
            Cart::create([
                'User_id' => null,
                'Product_id' => $product->Product_id,
                'Size' => $request->size,
                'Quantity' => $request->quantity,
                'Price' => $product->Price,
                'Total_price' => $product->Price * $request->quantity,
            ]);
        }

        return back()->with('success', 'Added to cart');
    }

    /**
     * Display all items currently in the shopping cart.
     *
     * Retrieves all cart items along with their associated product details.
     * Calculates the grand total of all items for display in the cart view.
     *
     * @return \Illuminate\View\View Returns the cart page with the list of items and total price.
     */
    public function viewCart()
    {
        $cartItems = Cart::with('product')->get();
        $grandTotal = $cartItems->sum('Total_price');

        return view('cart', compact('cartItems', 'grandTotal'));
    }

    /**
     * Increase the quantity of a cart item by one.
     *
     * Ensures that the quantity does not exceed the available stock for the product.
     * Returns an error message if the user tries to exceed stock.
     *
     * @param int $id The ID of the cart item to increase.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the cart page.
     */
    public function increaseQuantity($id)
    {
        $cart = Cart::findOrFail($id);
        $product = $cart->product;

        if ($cart->Quantity + 1 > $product->Avaliable_quantity) {
            return back()->with('error', 'Not enough stock!');
        }

        $cart->Quantity++;
        $cart->Total_price = $cart->Quantity * $product->Price;
        $cart->save();

        return back();
    }

    /**
     * Decrease the quantity of a cart item by one.
     *
     * If the quantity becomes zero or one, the item is removed from the cart.
     * Otherwise, the total price is updated accordingly.
     *
     * @param int $id The ID of the cart item to decrease.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the cart page.
     */
    public function decreaseQuantity($id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart->Quantity <= 1) {
            $cart->delete();
            return back();
        }

        $cart->Quantity--;
        $cart->Total_price = $cart->Quantity * $cart->Price;
        $cart->save();

        return back();
    }

    /**
     * Remove a product completely from the cart.
     *
     * Deletes the cart item specified by its ID.
     *
     * @param int $id The ID of the cart item to remove.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the cart page.
     */
    public function removeItem($id)
    {
        Cart::destroy($id);
        return back();
    }

    /**
     * Confirm the current order for all items in the cart.
     *
     * Checks the stock availability for each product size and deducts
     * the purchased quantity. Clears the cart once the order is confirmed.
     * Returns a success message if the order is completed or an error
     * if any stock issues are found.
     *
     * @return \Illuminate\Http\RedirectResponse Redirects to the home page with a confirmation message.
     */
    public function confirmOrder()
    {
        $cartItems = Cart::with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Cart is empty!');
        }

        foreach ($cartItems as $item) {
            $sizeStock = \App\Models\ProductSize::where('Product_id', $item->Product_id)
                                                ->where('Size', $item->Size)
                                                ->first();

            if ($item->Quantity > $sizeStock->Quantity) {
                return back()->with('error', 'Not enough stock for size ' . $item->Size);
            }

            $sizeStock->Quantity -= $item->Quantity;
            $sizeStock->save();

            if ($sizeStock->Quantity <= 0) {
                $sizeStock->delete();
            }
        }

        Cart::query()->delete();

        return redirect('/')->with('success', 'Order Confirmed Successfully!');
    }
}
