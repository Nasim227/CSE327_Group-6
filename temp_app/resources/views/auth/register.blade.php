@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="flex justify-center mb-12">
            <div class="flex items-center justify-center">
                <img
                    src="{{ asset('csm-logo.png') }}"
                    alt="CMS Logo"
                    style="width: 160px; height: 160px; clip-path: inset(0 15px 0 0);"
                    class="w-40 h-40 object-contain"
                />
            </div>
        </div>

        {{-- Heading and Subheading --}}
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 mb-2">CMS SIGNUP</h1>
            <p class="text-gray-600 text-sm leading-relaxed">
                Start building your perfect wardrobe. Save your sizes, track orders effortlessly, and never miss a new drop.
            </p>
        </div>

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

        {{-- Signup Form --}}
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            {{-- First Name Input --}}
            <div>
                <input
                    type="text"
                    name="First_name"
                    placeholder="First Name"
                    value="{{ old('First_name') }}"
                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition-colors"
                    required
                />
            </div>

            {{-- Last Name Input --}}
            <div>
                <input
                    type="text"
                    name="Last_name"
                    placeholder="Last Name"
                    value="{{ old('Last_name') }}"
                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition-colors"
                    required
                />
            </div>

            {{-- Email Input --}}
            <div>
                <input
                    type="email"
                    name="Email"
                    placeholder="Email address*"
                    value="{{ old('Email') }}"
                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition-colors"
                    required
                />
            </div>

            {{-- Password Input --}}
            <div class="relative" x-data="{ showPassword: false }">
                <input
                    :type="showPassword ? 'text' : 'password'"
                    name="password"
                    placeholder="Password*"
                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition-colors pr-10"
                    required
                />
                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                >
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5" style="display: none;"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                </button>
            </div>

             {{-- Confirm Password Input (Added for backend compatibility) --}}
             <div class="relative">
                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm Password*"
                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition-colors pr-10"
                    required
                />
            </div>

            {{-- Email Preferences Checkbox --}}
            <div class="flex items-start gap-3 pt-2">
                <input
                    type="checkbox"
                    id="emailPreferences"
                    name="emailPreferences"
                    class="mt-1 w-4 h-4 rounded border-gray-300 cursor-pointer text-black focus:ring-black"
                />
                <label for="emailPreferences" class="text-xs text-gray-600 leading-relaxed cursor-pointer">
                    Tick here to receive emails about our products, content updates, exclusive releases and more. See our
                    <a href="#" class="underline font-semibold hover:text-black transition-colors">
                        Privacy Policy
                    </a>
                    and
                    <a href="#" class="underline font-semibold hover:text-black transition-colors">
                        Terms of Service
                    </a>
                </label>
            </div>

            {{-- Submit Button --}}
            <button
                type="submit"
                class="w-full mt-6 px-6 py-3 bg-black text-white font-semibold rounded-full hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2"
            >
                CREATE ACCOUNT
            </button>
        </form>

        {{-- Already have account --}}
        <div class="text-center mt-6 text-sm">
            <span class="text-gray-600">Already have an account? </span>
            <a href="{{ route('login') }}" class="font-semibold text-black hover:underline">
                Log in
            </a>
        </div>
    </div>
</div>

{{-- Alpine.js for interactivity --}}
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
