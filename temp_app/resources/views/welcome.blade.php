@extends('layouts.app')

@section('content')
<div class="text-center py-12">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">Welcome to CSE327 App</h1>
    <p class="text-lg text-gray-600 mb-8">Your one-stop shop for amazing products.</p>
    
    @guest
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">Login</a>
            <a href="{{ route('register') }}" class="bg-white text-indigo-600 border border-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition duration-300">Register</a>
        </div>
    @else
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative inline-block" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">You are logged in!</span>
        </div>
    @endguest
</div>
@endsection
