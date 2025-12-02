<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
/**
 * Web Routes
 *
 * Defines all HTTP routes for the application.
 *
 * @package routes
 */



/**
 * Display all products
 *
 * Shows the list of products available in the store.
 *
 * @route GET /
 * @name products_list
 */
Route::get('/', [ProductController::class, 'show_products'])->name('products.list');

/**
 * Add a product to the cart
 *
 * Handles adding selected product with quantity and size.
 *
 * @route POST /cart/add
 * @name cart.add
 */
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

/**
 * View cart items
 *
 * Displays all items currently in the user's shopping cart.
 *
 * @route GET /cart
 * @name cart.view
 */
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');

/**
 * Increase item quantity
 *
 * Increases the quantity of a specific product in the cart.
 *
 * @route POST /cart/increase/{id}
 * @param int $id The product ID
 * @name cart.increase
 */
Route::post('/cart/increase/{id}', [CartController::class, 'increaseQuantity'])->name('cart.increase');

/**
 * Decrease item quantity
 *
 * Decreases the quantity of a specific product in the cart.
 *
 * @route POST /cart/decrease/{id}
 * @param int $id The product ID
 * @name cart.decrease
 */
Route::post('/cart/decrease/{id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');

/**
 * Remove item from cart
 *
 * Removes a product completely from the cart.
 *
 * @route POST /cart/remove/{id}
 * @param int $id The product ID
 * @name cart.remove
 */
Route::post('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');