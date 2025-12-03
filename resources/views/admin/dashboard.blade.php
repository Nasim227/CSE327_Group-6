@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <nav class="bg-indigo-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <span class="font-bold text-xl">Admin Portal</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span>Welcome, {{ Auth::guard('admin')->user()->name }}</span>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="bg-indigo-700 hover:bg-indigo-800 px-3 py-2 rounded-md text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="border-4 border-dashed border-gray-200 rounded-lg h-96 flex items-center justify-center">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-700">Admin Dashboard</h2>
                    <p class="mt-2 text-gray-500">Manage your application here.</p>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
