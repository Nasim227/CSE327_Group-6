<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Handles CRUD operations for products in the admin dashboard.
 * 
 * This controller provides methods to create, update, and delete products
 * in the store's inventory. All routes are protected by admin authentication.
 * 
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    /**
     * Store a newly created product in the database.
     * 
     * Validates the input data and creates a new product record.
     * 
     * @param  \Illuminate\Http\Request  $request  Contains name, price, stock, status
     * @return \Illuminate\Http\RedirectResponse  Redirects back with success message
     */
    public function store(Request $request)
    {
        // Validate input - Laravel will redirect back with errors if validation fails
        // 'required' = field cannot be empty
        // 'numeric|min:0' = must be a number >= 0
        // 'in:...' = must be one of the listed values
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|string|in:Active,Low Stock,Out of Stock',
        ]);

        // Create the product - only $fillable fields can be mass-assigned
        Product::create($validated);

        // Redirect back with a flash message
        return back()->with('success', 'Product added successfully!');
    }

    /**
     * Update an existing product's details.
     * 
     * Uses Route Model Binding - Laravel automatically finds the product by ID.
     * 
     * @param  \Illuminate\Http\Request  $request  Contains price, stock, status
     * @param  \App\Models\Product  $product  The product to update (auto-loaded)
     * @return \Illuminate\Http\RedirectResponse  Redirects back with success message
     */
    public function update(Request $request, Product $product)
    {
        // Validate - note: we don't allow changing the product name
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|string|in:Active,Low Stock,Out of Stock',
        ]);

        // Update the product - only changes the specified fields
        $product->update($validated);

        return back()->with('success', 'Product updated successfully!');
    }

    /**
     * Remove a product from the database.
     * 
     * Permanently deletes the product record (hard delete).
     * 
     * @param  \App\Models\Product  $product  The product to delete (auto-loaded)
     * @return \Illuminate\Http\RedirectResponse  Redirects back with success message
     */
    public function destroy(Product $product)
    {
        // Delete the product from the database
        $product->delete();
        
        return back()->with('success', 'Product deleted successfully!');
    }
}
