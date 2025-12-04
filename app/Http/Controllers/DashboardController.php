<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;

/**
 * Manages user and admin dashboard views.
 * 
 * Handles fetching data for dashboard displays and provides
 * admin functionality for user management.
 * 
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     * 
     * Shows the customer's personal hub with their orders
     * and the T-shirt customization studio.
     * 
     * @return \Illuminate\View\View
     */
    public function userDashboard()
    {
        // Dummy order data for presentation
        // In production: Order::where('user_id', Auth::id())->get()
        $orders = [
            [
                'id' => '#ORD-7782',
                'date' => 'Dec 01, 2025',
                'status' => 'Shipped',
                'total' => '$45.00',
                'items' => 'Vintage T-Shirt (x1)'
            ],
            [
                'id' => '#ORD-7781',
                'date' => 'Nov 28, 2025',
                'status' => 'Delivered',
                'total' => '$120.50',
                'items' => 'Denim Jacket (x1), Cap (x1)'
            ]
        ];

        return view('dashboard.user', compact('orders'));
    }

    /**
     * Display the admin dashboard.
     * 
     * Shows the admin command center with system statistics,
     * user list, and product inventory management.
     * 
     * @return \Illuminate\View\View
     */
    public function adminDashboard()
    {
        // Get 5 most recent users
        $users = User::latest('User_id')->take(5)->get();
        
        // Dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'total_sales' => '$12,450',
            'active_orders' => '24',
            'pending_support' => '5'
        ];

        // Fetch all products from database
        $products = \App\Models\Product::all();

        return view('dashboard.admin', compact('users', 'stats', 'products'));
    }

    /**
     * Toggle a user's active/inactive status.
     * 
     * Switches the user's status between 'active' and 'inactive'.
     * Inactive users are blocked by the CheckUserStatus middleware.
     * 
     * @param  \App\Models\User  $user  The user to toggle (Route Model Binding)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleUserStatus(User $user)
    {
        // Flip the status using ternary operator
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return back()->with('success', 'User status updated successfully!');
    }
}
