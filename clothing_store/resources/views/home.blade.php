<!-- resources/views/home.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing Store</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet"> <!-- Linking CSS -->
</head>
<body>
    <!-- Header and Navigation -->
    <header>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Shop</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </header>
    
    <!-- Hero Section -->
    <section class="hero">
        <h1>Welcome to Our Clothing Store</h1>
        <p>Find the best fashion here!</p>
        <a href="#" class="btn">Shop Now</a>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Clothing Store. All rights reserved.</p>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script> <!-- Linking JS -->
</body>
</html>
