@extends('layouts.blank')

@section('content')
{{-- 
    ADMIN DASHBOARD TEMPLATE
    
    Design Philosophy: "Command Center"
    - Information dense but clean
    - Sidebar navigation with Tab Switching (Alpine.js)
    - Key metrics at a glance
--}}

<div class="min-h-screen bg-gray-100 flex" x-data="{ 
    currentTab: 'dashboard',
    showAddProductModal: false,
    showEditProductModal: false,
    editProductForm: {
        id: null,
        name: '',
        price: '',
        stock: '',
        status: 'Active'
    },
    openEditModal(product) {
        this.editProductForm = {
            id: product.id,
            name: product.name,
            price: product.price,
            stock: product.stock,
            status: product.status
        };
        this.showEditProductModal = true;
    }
}">
    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-900 text-white flex-shrink-0 hidden md:flex flex-col transition-all duration-300">
        <div class="p-6 border-b border-gray-800 flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center font-bold">A</div>
            <span class="text-xl font-bold tracking-wider">ADMIN</span>
        </div>
        
        <nav class="flex-1 p-4 space-y-2">
            {{-- Dashboard Tab --}}
            <button @click="currentTab = 'dashboard'" 
                :class="{ 'bg-blue-600 text-white shadow-lg': currentTab === 'dashboard', 'text-gray-400 hover:bg-gray-800 hover:text-white': currentTab !== 'dashboard' }"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </button>

            {{-- Users Tab --}}
            <button @click="currentTab = 'users'" 
                :class="{ 'bg-blue-600 text-white shadow-lg': currentTab === 'users', 'text-gray-400 hover:bg-gray-800 hover:text-white': currentTab !== 'users' }"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Users
            </button>

            {{-- Products Tab --}}
            <button @click="currentTab = 'products'" 
                :class="{ 'bg-blue-600 text-white shadow-lg': currentTab === 'products', 'text-gray-400 hover:bg-gray-800 hover:text-white': currentTab !== 'products' }"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Products
            </button>

            {{-- Analytics Tab (Placeholder) --}}
            <button @click="currentTab = 'analytics'" 
                :class="{ 'bg-blue-600 text-white shadow-lg': currentTab === 'analytics', 'text-gray-400 hover:bg-gray-800 hover:text-white': currentTab !== 'analytics' }"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Analytics
            </button>
        </nav>

        <div class="p-4 border-t border-gray-800">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-gray-800 hover:text-red-300 rounded-lg w-full transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 overflow-y-auto h-screen relative">
        {{-- Header --}}
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center sticky top-0 z-10">
            <h1 class="text-2xl font-bold text-gray-800" x-text="currentTab.charAt(0).toUpperCase() + currentTab.slice(1) + ' Overview'"></h1>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-500">Logged in as Admin</span>
                <div class="h-8 w-8 rounded-full bg-gray-900 text-white flex items-center justify-center font-bold">
                    A
                </div>
            </div>
        </header>

        <div class="p-8">
            {{-- DASHBOARD VIEW --}}
            <div x-show="currentTab === 'dashboard'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                {{-- Stats Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    {{-- Stat Card 1 --}}
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-500">Total Users</h3>
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</span>
                            <span class="text-sm text-green-500 font-medium">+12%</span>
                        </div>
                    </div>

                    {{-- Stat Card 2 --}}
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-500">Total Sales</h3>
                            <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-bold text-gray-900">{{ $stats['total_sales'] }}</span>
                            <span class="text-sm text-green-500 font-medium">+8%</span>
                        </div>
                    </div>

                    {{-- Stat Card 3 --}}
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-500">Active Orders</h3>
                            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-bold text-gray-900">{{ $stats['active_orders'] }}</span>
                            <span class="text-sm text-gray-500 font-medium">Processing</span>
                        </div>
                    </div>

                    {{-- Stat Card 4 --}}
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-500">Pending Support</h3>
                            <div class="p-2 bg-orange-50 text-orange-600 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-bold text-gray-900">{{ $stats['pending_support'] }}</span>
                            <span class="text-sm text-red-500 font-medium">Action Needed</span>
                        </div>
                    </div>
                </div>
                
                {{-- Quick Preview Section (Both tables side by side) --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Quick User View</h3>
                        <p class="text-sm text-gray-500">Switch to the "Users" tab for full details.</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Quick Inventory View</h3>
                        <p class="text-sm text-gray-500">Switch to the "Products" tab for full details.</p>
                    </div>
                </div>
            </div>

            {{-- USERS VIEW --}}
            <div x-show="currentTab === 'users'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <h3 class="font-bold text-gray-800">All Users</h3>
                        {{-- REMOVED SEARCH BAR AS REQUESTED --}}
                    </div>
                    <table class="w-full text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $user->First_name }} {{ $user->Last_name }}</td>
                                <td class="px-6 py-3 text-gray-500 text-sm">{{ $user->Email }}</td>
                                <td class="px-6 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user->User_id) }}">
                                        @csrf
                                        <button type="submit" class="text-sm font-medium {{ $user->status === 'active' ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}">
                                            {{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- PRODUCTS VIEW --}}
            <div x-show="currentTab === 'products'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <h3 class="font-bold text-gray-800">Product Inventory</h3>
                        <button @click="showAddProductModal = true" class="text-sm bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Product
                        </button>
                    </div>
                    <table class="w-full text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Product</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Stock</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Price</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-6 py-3 text-gray-500">{{ $product->stock }}</td>
                                <td class="px-6 py-3 text-gray-500">${{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-3">
                                    @if($product->status == 'Active')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">● Active</span>
                                    @elseif($product->status == 'Low Stock')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">● Low Stock</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">● Out of Stock</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 flex gap-3">
                                    <button @click="openEditModal({{ $product }})" class="text-blue-600 hover:text-blue-900 text-sm font-medium">Edit</button>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ANALYTICS VIEW --}}
            <div x-show="currentTab === 'analytics'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Advanced Analytics</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Detailed reports and charts are being generated. Check back later for sales trends and user growth analysis.</p>
                </div>
            </div>

        </div>
    </main>

    {{-- Add Product Modal --}}
    <div x-show="showAddProductModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6" @click.away="showAddProductModal = false">
            <h3 class="text-lg font-bold mb-4">Add New Product</h3>
            <form method="POST" action="{{ route('admin.products.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" step="0.01" name="price" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" name="stock" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="Active">Active</option>
                            <option value="Low Stock">Low Stock</option>
                            <option value="Out of Stock">Out of Stock</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showAddProductModal = false" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save Product</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Product Modal --}}
    <div x-show="showEditProductModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6" @click.away="showEditProductModal = false">
            <h3 class="text-lg font-bold mb-4">Edit Product</h3>
            <form method="POST" :action="`{{ route('admin.products.update', 'ID') }}`.replace('ID', editProductForm.id)">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" x-model="editProductForm.name" disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" step="0.01" name="price" x-model="editProductForm.price" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" name="stock" x-model="editProductForm.stock" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" x-model="editProductForm.status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="Active">Active</option>
                            <option value="Low Stock">Low Stock</option>
                            <option value="Out of Stock">Out of Stock</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showEditProductModal = false" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
