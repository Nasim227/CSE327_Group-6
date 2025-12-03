{{--
    BLADE TEMPLATE: Login Page
    
    WHAT THIS FILE IS:
    This is a Blade template - Laravel's way of creating HTML pages.
    Blade is Laravel's templating engine that makes HTML dynamic.
    
    WHAT THIS PAGE DOES:
    This shows the login form where customers enter their email and password.
    
    BLADE SYNTAX BASICS:
    - {{ $variable }} = Print a PHP variable
    - @if, @foreach, @csrf = Blade directives (special commands)
    - {{-- comment -- }} = Blade comments (won't appear in HTML)
    
    FILE LOCATION:
    resources/views/auth/login.blade.php
--}}

{{--
    @extends tells Blade: "Use the layout from layouts/app.blade.php as a template"
    This means we inherit the header, footer, and basic structure from app.blade.php
--}}
@extends('layouts.app')

{{--
    @section('content') means: "Everything between here and @endsection goes into
    the 'content' section of the parent layout (app.blade.php)"
    
    Think of it like filling in a blank in a template:
    - app.blade.php has a blank spot called @yield('content')
    - This page fills in that blank with the login form
--}}
@section('content')

{{-- 
    MAIN CONTAINER
    - min-h-screen = Minimum height is the full screen (so form is centered vertically)
    - bg-white = White background
    - flex items-center justify-center = Center everything horizontally and vertically
    - px-4 = Padding on left and right (for mobile screens)
--}}
<div class="min-h-screen bg-white flex items-center justify-center px-4">
    {{-- 
        FORM CARD CONTAINER
        - w-full = Full width (but...)
        - max-w-md = ...but maximum width is medium (prevents form from being too wide on big screens)
    --}}
    <div class="w-full max-w-md">
        
        {{-- ========== LOGO SECTION ========== --}}
        {{-- 
            This shows the company logo at the top of the form
            The "flex justify-center" centers the logo horizontally
        --}}
        <div class="flex justify-center mb-2">
            <div class="bg-white p-8 rounded-lg flex items-center justify-center">
                {{--
                    {{ asset('csm-logo.png') }} is a Blade directive that generates the URL to a file in the /public folder
                    So if you have /public/csm-logo.png, {{ asset('csm-logo.png') }} becomes "https://example.com/csm-logo.png"
                --}}
                <img src="{{ asset('csm-logo.png') }}" alt="CSM Logo" style="width: 160px; height: auto; clip-path: inset(0 15px 0 0);" />
            </div>
        </div>

        {{-- ========== PAGE HEADING ========== --}}
        {{--
            The main title "CMS LOGIN"
            - text-center = Centered text
            - text-2xl = Large text (2 times extra large)
            - font-bold = Bold text
            - tracking-wide = Spread out letters slightly
            - mb-4 = Margin bottom (space below the heading)
        --}}
        <h1 class="text-center text-2xl font-bold tracking-wide mb-4">CMS LOGIN</h1>

        {{-- ========== TAGLINE ========== --}}
        {{--
            Subheading text that explains what the login is for
            - text-sm = Small text
            - text-gray-600 = Medium gray color
            - mb-8 = More margin at bottom to separate from form
        --}}
        <p class="text-center text-sm text-gray-600 mb-8 leading-relaxed">
            Shop your styles, save top picks to your wishlist,
            <br />
            track those orders & connect with us.
        </p>

        {{-- ========== ERROR MESSAGES ========== --}}
        {{--
            @if ($errors->any()) checks: "Are there any validation errors?"
            
            HOW THIS WORKS:
            1. User submits the login form
            2. Controller validates email and password
            3. If validation fails, Laravel automatically sends user back here
            4. Laravel includes any error messages in the $errors variable
            5. This code displays those errors in a red box
            
            EXAMPLE ERRORS:
            - "The Email field is required."
            - "The provided credentials do not match our records."
        --}}
        @if ($errors->any())
            {{-- Red error box with border --}}
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    {{--
                        @foreach loops through all the errors
                        $errors->all() gets all error messages as an array
                        
                        For each error, we display it as a list item
                    --}}
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ========== LOGIN FORM ========== --}}
        {{--
            THE FORM ELEMENT
            
            Attributes explained:
            - method="POST" = When submitted, send data as a POST request (not GET)
                             POST is used for forms that change data (login, registration, etc.)
                             GET is used for viewing pages (search, filtering, etc.)
            
            - action="{{ route('login') }}" = Where to send the form data when submitted
                                              {{ route('login') }} generates the URL for the login route
                                              This points to AuthController@login_user
            
            - class="space-y-6" = Add 6 units of vertical space between each child element (fields)
        --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            
            {{--
                @csrf = Cross-Site Request Forgery protection
                
                WHAT THIS DOES:
                Laravel includes a hidden field with a security token.
                When the form is submitted, Laravel checks this token.
                If the token is missing or wrong, the request is rejected.
                
                WHY WE NEED IT:
                Prevents attackers from tricking users into submitting forms
                they didn't mean to submit (CSRF attacks).
                
                WHAT IT BECOMES:
                <input type="hidden" name="_token" value="random_secure_token_here">
            --}}
            @csrf
            
            {{-- ========== EMAIL INPUT FIELD ========== --}}
            {{--
                The email input where user types their email address
                
                Attributes explained:
                - type="email" = This field expects an email address
                                 Browsers will validate format (must have @ symbol, etc.)
                
                - name="Email" = The name of this field
                                 When form is submitted, data is sent as: Email=user@example.com
                                 Controller receives this in $request->Email or $request->input('Email')
                
                - placeholder="Email address*" = Gray text shown when field is empty
                                                 The * means "required field"
                
                - value="{{ old('Email') }}" = If form submission fails (wrong password, etc.),
                                                keep the email field filled in
                                                old() retrieves previously submitted values
                
                - required = HTML5 validation: browser won't submit if field is empty
                
                - autofocus = Automatically put cursor in this field when page loads
                              So user can start typing immediately
            --}}
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

            {{-- ========== PASSWORD INPUT FIELD WITH TOGGLE ========== --}}
            {{--
                The password field with a "show/hide" button
                
                x-data="{ showPassword: false }" is Alpine.js (a simple JavaScript framework)
                - Creates a variable called "showPassword" set to false
                - This controls whether the password is visible or hidden
                
                HOW SHOW/HIDE WORKS:
                1. By default, showPassword = false, so type="password" (dots instead of text)
                2. User clicks the eye icon
                3. showPassword becomes true
                4. :type changes from "password" to "text" (shows actual characters)
                5. Clicking again toggles it back
            --}}
            <div class="relative" x-data="{ showPassword: false }">
                {{--
                    PASSWORD INPUT
                    
                    :type="showPassword ? 'text' : 'password'" is Alpine.js syntax
                    - If showPassword is true, type="text" (password visible)
                    - If showPassword is false, type="password" (password hidden with dots)
                    
                    This is called a "conditional attribute" or "ternary operator"
                    Format: condition ? valueIfTrue : valueIfFalse
                --}}
                <input
                    :type="showPassword ? 'text' : 'password'"
                    name="password"
                    placeholder="Password*"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent text-sm"
                    required
                />
                
                {{--
                    SHOW/HIDE PASSWORD BUTTON (THE EYE ICON)
                    
                    - type="button" = This doesn't submit the form, it just runs JavaScript
                    
                    - @click="showPassword = !showPassword" is Alpine.js
                      When clicked, flip the value of showPassword
                      If it was false, make it true. If it was true, make it false.
                      
                    - absolute right-4 top-1/2 = Position the button inside the input field on the right side
                --}}
                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                    :aria-label="showPassword ? 'Hide password' : 'Show password'"
                >
                    {{-- Icon shown when password is HIDDEN (closed eye) --}}
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    
                    {{-- Icon shown when password is VISIBLE (open eye with slash) --}}
                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5" style="display: none;"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                </button>
            </div>

            {{-- ========== REMEMBER ME CHECKBOX ========== --}}
            {{--
                Checkbox that lets user stay logged in even after closing browser
                
                HOW IT WORKS:
                - User checks this box and logs in
                - Controller sees $request->has('remember') returns true
                - Controller creates a long-lived "remember_token" in the database
                - Next time user visits, they're automatically logged in
                - Without this, session expires when browser closes
            --}}
            <div class="flex items-center">
                <input
                    type="checkbox"
                    id="rememberMe"
                    name="remember"
                    class="w-4 h-4 border border-gray-300 rounded focus:ring-2 focus:ring-black cursor-pointer"
                />
                {{--
                    <label for="rememberMe"> connects this text to the checkbox above
                    Clicking the text will also check/uncheck the box
                    The "for" attribute must match the "id" of the checkbox
                --}}
                <label for="rememberMe" class="ml-2 text-sm text-gray-600 cursor-pointer">
                    Remember me
                </label>
            </div>

            {{-- ========== FORGOT PASSWORD LINK ========== --}}
            {{--
                Link to reset password (currently points to #, would point to password reset page)
                
                The underline hover:no-underline creates an interactive effect:
                - By default, text is underlined
                - When you hover over it, underline disappears
            --}}
            <div class="text-center">
                <a href="#" class="text-sm text-black font-semibold underline hover:no-underline transition-all">
                    Forgot password?
                </a>
            </div>

            {{-- ========== LOGIN SUBMIT BUTTON ========== --}}
            {{--
                The button that submits the form
                
                WHAT HAPPENS WHEN CLICKED:
                1. Browser validates required fields (email, password)
                2. If validation passes, form submits
                3. POST request sent to route('login') = AuthController@login_user
                4. Controller validates credentials
                5. If correct, user is logged in and redirected to home
                6. If wrong, user is sent back here with error message
                
                STYLING:
                - w-full = Button spans full width of form
                - bg-black text-white = Black background, white text
                - py-3 = Padding top and bottom (makes button taller)
                - rounded-full = Fully rounded corners (pill shape)
                - hover:bg-gray-900 = Darker when you hover over it
            --}}
            <button
                type="submit"
                class="w-full bg-black text-white py-3 rounded-full font-bold text-center hover:bg-gray-900 transition-colors"
            >
                LOG IN
            </button>
        </form>

        {{-- ========== SIGN UP LINK ========== --}}
        {{--
            Link to registration page for users who don't have an account yet
            
            {{ route('register') }} generates the URL for the register route
            This points to /register which shows the registration form
        --}}
        <p class="text-center text-sm mt-6">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-semibold text-black underline hover:no-underline transition-all">
                Sign up
            </a>
        </p>
    </div>
</div>

{{--
    ALPINE.JS SCRIPT
    
    This loads Alpine.js from a CDN (Content Delivery Network)
    Alpine.js is what makes the password show/hide toggle work
    
    - //unpkg.com/alpinejs = CDN URL for Alpine.js
    - defer = Load the script after the HTML has loaded (for better performance)
    
    WHY ALPINE.JS:
    It's a lightweight JavaScript framework (only 15kb)
    Perfect for simple interactions like showing/hiding elements
    Much simpler than React or Vue for small features
--}}
<script src="//unpkg.com/alpinejs" defer></script>

{{-- End of the @section('content') block --}}
@endsection
