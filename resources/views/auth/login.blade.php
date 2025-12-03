@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="flex justify-center mb-2">
            <div class="bg-white p-8 rounded-lg flex items-center justify-center">
                <img src="{{ asset('csm-logo.png') }}" alt="CSM Logo" style="width: 160px; height: auto; clip-path: inset(0 15px 0 0);" />
            </div>
        </div>

        {{-- Heading --}}
        <h1 class="text-center text-2xl font-bold tracking-wide mb-4">CMS LOGIN</h1>

        {{-- Tagline --}}
        <p class="text-center text-sm text-gray-600 mb-8 leading-relaxed">
            Shop your styles, save top picks to your wishlist,
            <br />
            track those orders & connect with us.
        </p>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            
            {{-- Email Input --}}
            <div>
                <input
                    type="email"
                    name="Email"
                    placeholder="Email address*"
                    value="{{ old('Email') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent text-sm"
                    required
                    autofocus
                />
            </div>

            {{-- Password Input --}}
            <div class="relative" x-data="{ showPassword: false }">
                <input
                    :type="showPassword ? 'text' : 'password'"
                    name="password"
                    placeholder="Password*"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent text-sm"
                    required
                />
                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                    :aria-label="showPassword ? 'Hide password' : 'Show password'"
                >
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5" style="display: none;"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                </button>
            </div>

            <div class="flex items-center">
                <input
                    type="checkbox"
                    id="rememberMe"
                    name="remember"
                    class="w-4 h-4 border border-gray-300 rounded focus:ring-2 focus:ring-black cursor-pointer"
                />
                <label for="rememberMe" class="ml-2 text-sm text-gray-600 cursor-pointer">
                    Remember me
                </label>
            </div>

            {{-- Forgot Password Link --}}
            <div class="text-center">
                <a href="#" class="text-sm text-black font-semibold underline hover:no-underline transition-all">
                    Forgot password?
                </a>
            </div>

            {{-- Login Button --}}
            <button
                type="submit"
                class="w-full bg-black text-white py-3 rounded-full font-bold text-center hover:bg-gray-900 transition-colors"
            >
                LOG IN
            </button>
        </form>

        {{-- Sign Up Link --}}
        <p class="text-center text-sm mt-6">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-semibold text-black underline hover:no-underline transition-all">
                Sign up
            </a>
        </p>
    </div>
</div>

{{-- Alpine.js for simple interactivity like password toggle --}}
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
