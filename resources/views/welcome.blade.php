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
        <div class="space-y-4">
            <p class="text-xl text-gray-800 font-medium">Welcome back, {{ Auth::user()->First_name }}!</p>
            <a href="{{ route('dashboard') }}" class="inline-block bg-black text-white px-8 py-3 rounded-full font-bold hover:bg-gray-800 transition duration-300 shadow-lg transform hover:-translate-y-1">
                Go to Dashboard
            </a>
        </div>
    @endguest
</div>
@endsection
