<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <a href="/" class="flex-shrink-0 flex items-center font-bold text-xl text-indigo-600">
                            CSE327 App
                        </a>
                    </div>
                    <div class="flex items-center">
                        @auth
                            <span class="text-gray-700 mr-4">Hello, {{ Auth::user()->First_name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 mr-4">Login</a>
                            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow container mx-auto px-4 py-8">
            @yield('content')
        </main>

        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-500 text-sm">&copy; {{ date('Y') }} CSE327 Group 6. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>
</html>
