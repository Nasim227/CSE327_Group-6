<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Clothing Store')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Global CSS for layout + product cards --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Page-specific CSS (search page, sidebar, etc.) --}}
    @yield('page_css')
</head>
<body>
    <div class="wrapper">
        @yield('content')
    </div>
</body>
</html>
