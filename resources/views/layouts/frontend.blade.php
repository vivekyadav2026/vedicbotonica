<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Vedic Botanica - Premium Organic Dhoop Cones & Sticks')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Discover Vedic Botanica. Shop 100% natural, charcoal-free, and organic cow dung dhoop sticks and cones crafted for spiritual rituals, meditation, and pure positive energy.')">
    <meta name="keywords" content="@yield('meta_keywords', 'Vedic Botanica, organic dhoop sticks, bambooless dhoop, cow dung dhoop, charcoal-free incense, natural dhoop cones, premium dhoop combos, ayurvedic incense, spiritual wellness')">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Vedic Botanica">
    <meta property="og:title" content="@yield('og_title', 'Vedic Botanica - Premium Organic Dhoop Cones & Sticks')">
    <meta property="og:description" content="@yield('og_description', 'Shop 100% natural, charcoal-free, and organic cow dung dhoop sticks and cones crafted for spiritual rituals, meditation, and pure positive energy.')">
    <meta property="og:image" content="@yield('og_image', asset('images/premium_dhoop_product.png'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('og_title', 'Vedic Botanica - Premium Organic Dhoop Cones & Sticks')">
    <meta property="twitter:description" content="@yield('og_description', 'Shop 100% natural, charcoal-free, and organic cow dung dhoop sticks and cones crafted for spiritual rituals, meditation, and pure positive energy.')">
    <meta property="twitter:image" content="@yield('og_image', asset('images/premium_dhoop_product.png'))">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&family=Cinzel+Decorative:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Playfair Display', serif; }

        /* Premium Header Nav Link Hover Effect */
        .nav-link {
            font-size: 0.725rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #4B5563; /* gray-600 */
            transition: color 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: #C49A6C; /* gold */
        }
        .logo-text {
            font-family: 'Cinzel Decorative', serif;
            color: #C49A6C; /* Luxury Gold */
        }
    </style>
</head>
<body class="font-sans antialiased text-text-main bg-white" x-data="{ mobileMenuOpen: false, searchOpen: false }">
    
    <!-- Premium Top Announcement Bar -->
    <div class="bg-[#FAF6F0] text-[#b0875b] py-2 text-center text-[10px] sm:text-xs font-bold tracking-widest uppercase border-b border-gray-100/70">
        <span>✨ Free Shipping Nationwide • <a href="{{ route('bundle.builder') }}" class="underline hover:text-gray-900 transition-colors">Shop Premium Combos & Save</a> • Premium Natural Vedic Formulations ✨</span>
    </div>

    <!-- Sticky Main Header -->
    <header class="bg-white sticky top-0 z-50 border-b border-[#FAF6F0] shadow-[0_2px_15px_rgba(0,0,0,0.02)] transition-all duration-300">
        <!-- Desktop Header (Centered Logo with Explore Menu & Utility Icons) -->
        <div class="hidden md:block max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20 relative">
                <!-- Left: Explore Button & Nav Links -->
                <div class="flex items-center space-x-6 lg:space-x-8">
                    <button @click="mobileMenuOpen = true" class="flex items-center gap-2.5 text-xs font-bold font-sans uppercase tracking-[0.2em] text-gray-700 hover:text-[#C49A6C] transition-all duration-300 focus:outline-none cursor-pointer group">
                        <i class="fa-solid fa-bars text-sm group-hover:scale-110 transition-transform"></i>
                        <span>Explore</span>
                    </button>
                    
                    <nav class="hidden lg:flex items-center space-x-4 lg:space-x-6">
                        <a href="{{ url('/') }}" class="text-[10px] font-bold font-sans uppercase tracking-wider text-gray-600 hover:text-[#C49A6C] transition-colors">Home</a>
                        <a href="{{ url('/shop') }}" class="text-[10px] font-bold font-sans uppercase tracking-wider text-gray-600 hover:text-[#C49A6C] transition-colors">Shop</a>
                        <a href="{{ route('bundle.builder') }}" class="text-[10px] font-bold font-sans uppercase tracking-wider text-[#C49A6C] hover:text-[#b0875b] transition-colors flex items-center gap-1.5"><i class="fa-solid fa-gift text-[9px]"></i> Premium Combos</a>
                        <a href="{{ url('/about') }}" class="text-[10px] font-bold font-sans uppercase tracking-wider text-gray-600 hover:text-[#C49A6C] transition-colors">About</a>
                        <a href="{{ url('/contact') }}" class="text-[10px] font-bold font-sans uppercase tracking-wider text-gray-600 hover:text-[#C49A6C] transition-colors">Contact</a>
                    </nav>
                </div>

                <!-- Center: Logo -->
                <div class="absolute left-1/2 -translate-x-1/2 flex-shrink-0 flex items-center transition-transform duration-300 hover:scale-102 z-10">
                    <a href="{{ url('/') }}" class="flex flex-col items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Vedic Botanica Logo" class="h-14 w-14 object-contain bg-white rounded-full p-1 border border-[#C49A6C] shadow-xs">
                        <span class="logo-text text-[9px] font-bold text-gray-800 tracking-[0.25em] uppercase mt-1.5 leading-none">Vedic Botanica</span>
                    </a>
                </div>

                <!-- Right: Icons -->
                <div class="flex items-center gap-2">
                    <!-- Search Icon -->
                    <button @click="searchOpen = !searchOpen" class="p-2 text-gray-500 hover:text-[#C49A6C] transition-all duration-300 hover:scale-110 focus:outline-none cursor-pointer" title="Search">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>
                    
                    @auth
                        <!-- Authenticated User Dropdown -->
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="p-2 text-gray-500 hover:text-[#C49A6C] transition-all duration-300 flex items-center focus:outline-none hover:scale-105">
                                <i class="fa-regular fa-user text-xl"></i>
                                <span class="ml-1.5 text-xs font-bold font-sans uppercase tracking-widest hidden lg:inline">{{ Auth::user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-[9px] ml-1 text-gray-400"></i>
                            </button>
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="transform opacity-0 scale-95 translate-y-1"
                                 x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="transform opacity-0 scale-95 translate-y-1"
                                 class="absolute right-0 mt-3 w-48 bg-white border border-gray-100 rounded-xl shadow-xl py-2 z-50" style="display: none;">
                                <a href="{{ url('/dashboard') }}" class="block px-4 py-2.5 text-xs text-gray-700 hover:bg-[#FAF6F0] hover:text-[#C49A6C] transition-colors font-sans font-semibold uppercase tracking-wider">My Dashboard</a>
                                <a href="{{ url('/profile') }}" class="block px-4 py-2.5 text-xs text-gray-700 hover:bg-[#FAF6F0] hover:text-[#C49A6C] transition-colors font-sans font-semibold uppercase tracking-wider">My Profile</a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2.5 text-xs text-red-500 hover:bg-red-50 hover:text-red-650 transition-colors font-sans font-semibold uppercase tracking-wider">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Guest User Icon -->
                        <a href="{{ route('login') }}" class="p-2 text-gray-500 hover:text-[#C49A6C] transition-all duration-300 hover:scale-110" title="Log In / Register">
                            <i class="fa-regular fa-user text-xl"></i>
                        </a>
                    @endauth
                    
                    <a href="{{ url('/wishlist') }}" class="p-2 text-gray-500 hover:text-[#C49A6C] transition-all duration-300 hover:scale-110 relative" title="Wishlist">
                        <i class="fa-regular fa-heart text-xl"></i>
                        <span id="wishlist-count-badge" class="absolute top-1 right-1 bg-[#C49A6C] text-white text-[9px] font-bold rounded-full h-4.5 w-4.5 flex items-center justify-center border border-white shadow-xs">{{ count(session()->get('wishlist', [])) }}</span>
                    </a>
                    
                    <a href="{{ url('/cart') }}" class="p-2 text-gray-500 hover:text-[#C49A6C] transition-all duration-300 hover:scale-110 relative" title="Shopping Cart">
                        <i class="fa-solid fa-cart-shopping text-xl"></i>
                        <span id="cart-count-badge" class="absolute top-1 right-1 bg-[#C49A6C] text-white text-[9px] font-bold rounded-full h-4.5 w-4.5 flex items-center justify-center border border-white shadow-xs">{{ array_sum(array_column(session()->get('cart', []), 'quantity')) }}</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile Header (Centered Logo: Hamburger left, Centered logo, side-by-side icons right) -->
        <div class="block md:hidden max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex justify-between items-center h-16 relative">
                <!-- Left: Hamburger Menu Button -->
                <div class="flex items-center w-12 z-10">
                    <button @click="mobileMenuOpen = true" class="p-2 text-gray-500 hover:text-[#C49A6C] transition-all duration-300 focus:outline-none cursor-pointer" title="Open Menu">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>

                <!-- Center: Logo -->
                <div class="absolute left-1/2 -translate-x-1/2 flex-shrink-0 flex items-center transition-transform duration-300 hover:scale-102 z-10">
                    <a href="{{ url('/') }}" class="flex flex-col items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Vedic Botanica Logo" class="h-10 w-10 object-contain bg-white rounded-full p-0.5 border border-[#C49A6C] shadow-xs">
                        <span class="logo-text text-[8px] font-bold text-gray-850 tracking-[0.2em] uppercase mt-1 leading-none">Vedic Botanica</span>
                    </a>
                </div>

                <!-- Right: Utility Icons -->
                <div class="flex items-center gap-0.5 z-10">
                    <!-- Search Icon -->
                    <button @click="searchOpen = !searchOpen" class="p-1.5 text-gray-500 hover:text-[#C49A6C] transition-all duration-300 hover:scale-110 focus:outline-none cursor-pointer" title="Search">
                        <i class="fa-solid fa-magnifying-glass text-base"></i>
                    </button>
                    
                    <a href="{{ url('/wishlist') }}" class="p-1.5 text-gray-500 hover:text-[#C49A6C] transition-all duration-300 relative" title="Wishlist">
                        <i class="fa-regular fa-heart text-base"></i>
                        <span id="wishlist-count-badge-mobile-header" class="absolute top-1 right-1 bg-[#C49A6C] text-white text-[8px] font-bold rounded-full h-3.5 w-3.5 flex items-center justify-center border border-white shadow-xs">{{ count(session()->get('wishlist', [])) }}</span>
                    </a>
                    
                    <a href="{{ url('/cart') }}" class="p-1.5 text-gray-500 hover:text-[#C49A6C] transition-all duration-300 relative" title="Shopping Cart">
                        <i class="fa-solid fa-cart-shopping text-base"></i>
                        <span id="cart-count-badge-mobile-header" class="absolute top-1 right-1 bg-[#C49A6C] text-white text-[8px] font-bold rounded-full h-3.5 w-3.5 flex items-center justify-center border border-white shadow-xs">{{ array_sum(array_column(session()->get('cart', []), 'quantity')) }}</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Search Slide-down Container -->
        <div x-show="searchOpen"
             x-transition:enter="transition ease-out duration-200 transform"
             x-transition:enter-start="-translate-y-2 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-150 transform"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="-translate-y-2 opacity-0"
             class="bg-[#FAF6F0] border-t border-gray-100 py-3.5 px-4 sm:px-6 lg:px-8 absolute left-0 right-0 z-45 shadow-md"
             style="display: none;">
            <div class="max-w-3xl mx-auto flex items-center">
                <form action="/shop" method="GET" class="w-full flex items-center relative m-0">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Type here to search fragrances (e.g. Dhoop, Sandal)..." class="w-full bg-white border border-gray-250 rounded-full py-2.5 pl-5 pr-12 text-sm focus:outline-none focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] transition-all" autofocus>
                    <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-[#C49A6C] transition-colors">
                        <i class="fa-solid fa-magnifying-glass text-base"></i>
                    </button>
                </form>
                <button @click="searchOpen = false" class="ml-4 text-gray-400 hover:text-red-500 transition-colors focus:outline-none cursor-pointer" title="Close Search">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Sidebar Drawer Menu Overlay -->
    <div x-show="mobileMenuOpen" 
         class="fixed inset-0 z-50 flex" 
         role="dialog" aria-modal="true" 
         style="display: none;">
        
        <!-- Backdrop -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/55 backdrop-blur-sm" 
             @click="mobileMenuOpen = false"></div>

        <!-- Drawer Content -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative flex w-full max-w-xs flex-col overflow-y-auto bg-white pb-12 shadow-2xl border-r border-gray-100">
            
            <!-- Close Button Header -->
            <div class="flex px-4 pt-5 pb-3 justify-between items-center border-b border-gray-50 bg-[#FAF6F0]">
                <img src="{{ asset('images/logo.png') }}" alt="Vedic Botanica Logo" class="h-12 w-auto object-contain">
                <button type="button" @click="mobileMenuOpen = false" class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-gray-400 hover:text-gray-900 border border-gray-100 shadow-sm focus:outline-none">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Links -->
            <div class="space-y-6 px-6 py-6 border-b border-gray-100">
                <a href="{{ url('/') }}" @click="mobileMenuOpen = false" class="block text-base font-serif font-bold text-gray-900 hover:text-[#C49A6C] transition-colors">Home</a>
                <a href="{{ url('/about') }}" @click="mobileMenuOpen = false" class="block text-base font-serif font-bold text-gray-900 hover:text-[#C49A6C] transition-colors">About Us</a>
                <a href="{{ url('/shop') }}" @click="mobileMenuOpen = false" class="block text-base font-serif font-bold text-gray-900 hover:text-[#C49A6C] transition-colors">Shop</a>
                <a href="{{ route('bundle.builder') }}" @click="mobileMenuOpen = false" class="block text-base font-serif font-bold text-[#C49A6C] hover:text-[#b0875b] transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-gift text-sm"></i>
                    <span>Premium Combos</span>
                </a>
                <a href="{{ url('/contact') }}" @click="mobileMenuOpen = false" class="block text-base font-serif font-bold text-gray-900 hover:text-[#C49A6C] transition-colors">Contact Us</a>
            </div>

            <div class="space-y-6 px-6 py-6">
                @auth
                    <p class="text-[10px] font-sans font-bold text-gray-400 uppercase tracking-widest">Account Area</p>
                    <a href="{{ url('/dashboard') }}" @click="mobileMenuOpen = false" class="block text-sm font-medium text-gray-700 hover:text-primary transition-colors">My Dashboard</a>
                    <a href="{{ url('/profile') }}" @click="mobileMenuOpen = false" class="block text-sm font-medium text-gray-700 hover:text-primary transition-colors">My Profile</a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="block w-full text-left text-sm font-medium text-red-650 hover:text-red-800 transition-colors">
                            Log Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" @click="mobileMenuOpen = false" class="flex items-center space-x-2 text-sm font-medium text-gray-700 hover:text-primary transition-colors">
                        <i class="fa-regular fa-user text-base"></i>
                        <span>Log In / Register</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile Sticky Bottom Nav Bar -->
    @if(!request()->is('product/*') && !request()->is('checkout') && !request()->is('checkout/*'))
    <div class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-150/70 shadow-[0_-4px_12px_rgba(0,0,0,0.05)] md:hidden flex justify-around items-center h-16 px-2 pb-safe-bottom">
        <a href="{{ url('/') }}" class="flex flex-col items-center justify-center w-12 text-center transition-colors {{ request()->is('/') ? 'text-primary' : 'text-gray-500' }}">
            <i class="fa-solid fa-house text-lg"></i>
            <span class="text-[9px] font-sans font-medium mt-0.5">Home</span>
        </a>
        <a href="{{ url('/shop') }}" class="flex flex-col items-center justify-center w-12 text-center transition-colors {{ request()->is('shop') ? 'text-primary' : 'text-gray-500' }}">
            <i class="fa-solid fa-store text-lg"></i>
            <span class="text-[9px] font-sans font-medium mt-0.5">Shop</span>
        </a>
        <a href="{{ url('/wishlist') }}" class="flex flex-col items-center justify-center w-12 text-center transition-colors relative {{ request()->is('wishlist') ? 'text-primary' : 'text-gray-500' }}">
            <i class="fa-regular fa-heart text-lg"></i>
            <span id="wishlist-count-badge-mobile" class="absolute top-1.5 right-2 bg-primary text-white text-[8px] font-bold rounded-full h-3.5 w-3.5 flex items-center justify-center">{{ count(session()->get('wishlist', [])) }}</span>
            <span class="text-[9px] font-sans font-medium mt-0.5">Wishlist</span>
        </a>
        <a href="{{ url('/cart') }}" class="flex flex-col items-center justify-center w-12 text-center transition-colors relative {{ request()->is('cart') ? 'text-primary' : 'text-gray-500' }}">
            <i class="fa-solid fa-cart-shopping text-lg"></i>
            <span id="cart-count-badge-mobile" class="absolute top-1.5 right-2 bg-primary text-white text-[8px] font-bold rounded-full h-3.5 w-3.5 flex items-center justify-center">{{ array_sum(array_column(session()->get('cart', []), 'quantity')) }}</span>
            <span class="text-[9px] font-sans font-medium mt-0.5">Cart</span>
        </a>
    </div>
    @endif

    <!-- Main Content -->
    <main class="pb-16 md:pb-0">
        @if (session('success') || session('error') || session('warning') || session('status'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                        <span>{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                        <span>{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif
                @if (session('warning'))
                    <div class="bg-yellow-50 border border-yellow-250 text-yellow-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                        <span>{{ session('warning') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-yellow-600 hover:text-yellow-800 cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif
                @if (session('status'))
                    <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                        <span>{{ session('status') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-700 cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Assured by Purity Section -->
    <div class="bg-[#FAF6F0]/80 py-16 border-t border-gray-150/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-xl sm:text-2xl font-serif font-bold text-gray-900 mb-10 tracking-wide">Assured by Purity</h2>
            <div class="grid grid-cols-3 gap-4 max-w-3xl mx-auto">
                <!-- Badge 1 -->
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full border border-[#C49A6C]/30 bg-white flex items-center justify-center shadow-xs transition-transform duration-500 hover:scale-108 hover:border-[#C49A6C]">
                        <i class="fa-solid fa-leaf text-xl sm:text-2xl text-[#C49A6C]"></i>
                    </div>
                    <span class="mt-4 font-serif font-bold text-[10px] sm:text-xs text-gray-800 tracking-wider uppercase">Natural Products</span>
                </div>
                <!-- Badge 2 -->
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full border border-[#C49A6C]/30 bg-white flex items-center justify-center shadow-xs transition-transform duration-500 hover:scale-108 hover:border-[#C49A6C]">
                        <i class="fa-solid fa-cow text-xl sm:text-2xl text-[#C49A6C]"></i>
                    </div>
                    <span class="mt-4 font-serif font-bold text-[10px] sm:text-xs text-gray-800 tracking-wider uppercase">Pure Cow Dung</span>
                </div>
                <!-- Badge 3 -->
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full border border-[#C49A6C]/30 bg-white flex items-center justify-center shadow-xs transition-transform duration-500 hover:scale-108 hover:border-[#C49A6C]">
                        <i class="fa-solid fa-ban text-xl sm:text-2xl text-[#C49A6C]"></i>
                    </div>
                    <span class="mt-4 font-serif font-bold text-[10px] sm:text-xs text-gray-800 tracking-wider uppercase">Charcoal Free</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Delivered With Section -->
    <div class="bg-[#FAF6F0] py-12 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-[10px] text-gray-400 uppercase tracking-widest font-bold font-sans mb-8">Delivered With</h3>
            <div class="grid grid-cols-2 gap-3 md:flex md:flex-row md:flex-wrap md:items-center md:justify-center md:gap-8 lg:gap-16">
                <!-- Make In India -->
                <div class="flex items-center space-x-2 sm:space-x-3 bg-[#FAF6F0]/40 border border-[#C49A6C]/10 rounded-2xl px-3 py-2.5 sm:px-5 sm:py-3 shadow-xs hover:border-[#C49A6C]/40 transition-colors w-full md:w-auto">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-[#C49A6C] flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15.5h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                    </svg>
                    <div class="text-left min-w-0">
                        <span class="block text-[9px] sm:text-[10px] font-sans font-bold text-gray-900 tracking-wider leading-none uppercase truncate">Make In India</span>
                        <span class="text-[7px] sm:text-[8px] font-sans text-gray-400 mt-1 block truncate">Local Artisans</span>
                    </div>
                </div>

                <!-- Ayush Ministry -->
                <div class="flex items-center space-x-2 sm:space-x-3 bg-[#FAF6F0]/40 border border-[#C49A6C]/10 rounded-2xl px-3 py-2.5 sm:px-5 sm:py-3 shadow-xs hover:border-[#C49A6C]/40 transition-colors w-full md:w-auto">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-[#C49A6C] flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10zm-1-6l-3-3 1.41-1.41L11 13.17l4.59-4.59L17 10l-6 6z"/>
                    </svg>
                    <div class="text-left min-w-0">
                        <span class="block text-[9px] sm:text-[10px] font-sans font-bold text-gray-900 tracking-wider leading-none uppercase truncate">Ayush Certified</span>
                        <span class="text-[7px] sm:text-[8px] font-sans text-gray-400 mt-1 block truncate">Standard Quality</span>
                    </div>
                </div>

                <!-- 100% Organic -->
                <div class="flex items-center space-x-2 sm:space-x-3 bg-[#FAF6F0]/40 border border-[#C49A6C]/10 rounded-2xl px-3 py-2.5 sm:px-5 sm:py-3 shadow-xs hover:border-[#C49A6C]/40 transition-colors w-full md:w-auto">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-[#C49A6C] flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 8C8 10 5.9 16.17 6 20c.07 2.76 2.24 5 5 5h2c2.76 0 4.93-2.24 5-5 .1-3.83-2-9.83-11-12m-3 14c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"/>
                    </svg>
                    <div class="text-left min-w-0">
                        <span class="block text-[9px] sm:text-[10px] font-sans font-bold text-gray-900 tracking-wider leading-none uppercase truncate">100% Organic</span>
                        <span class="text-[7px] sm:text-[8px] font-sans text-gray-400 mt-1 block truncate">Nature Sourced</span>
                    </div>
                </div>

                <!-- Logistics Partner -->
                <div class="flex items-center space-x-2 sm:space-x-3 bg-[#FAF6F0]/40 border border-[#C49A6C]/10 rounded-2xl px-3 py-2.5 sm:px-5 sm:py-3 shadow-xs hover:border-[#C49A6C]/40 transition-colors w-full md:w-auto">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-[#C49A6C] flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm12 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1-5.5h-2.5V10H17l2 3z"/>
                    </svg>
                    <div class="text-left min-w-0">
                        <span class="block text-[9px] sm:text-[10px] font-sans font-bold text-gray-900 tracking-wider leading-none uppercase truncate">Express Shipping</span>
                        <span class="text-[7px] sm:text-[8px] font-sans text-gray-400 mt-1 block truncate">Secure Delivery</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gayatri Mantra Marquee Ribbon -->
    <div class="bg-gradient-to-r from-[#D4A373] via-[#C49A6C] to-[#D4A373] py-4 overflow-hidden border-t border-b border-[#C49A6C]/20 relative shadow-inner">
        <div class="flex whitespace-nowrap font-serif text-white text-xs sm:text-sm md:text-base font-bold tracking-widest uppercase leading-none">
            <div class="animate-marquee flex flex-row items-center">
                <span class="mx-8 flex items-center gap-2"><span class="text-[#FAF6F0] text-lg">ॐ</span> भूर्भुवः स्वः तत्सवितुर्वरेण्यं भर्गो देवस्य धीमहि धियो यो नः प्रचोदयात् ॥</span>
                <span class="mx-8 flex items-center gap-2"><span class="text-[#FAF6F0] text-lg">ॐ</span> भूर्भुवः स्वः तत्सवितुर्वरेण्यं भर्गो देवस्य धीमहि धियो यो नः प्रचोदयात् ॥</span>
                <span class="mx-8 flex items-center gap-2"><span class="text-[#FAF6F0] text-lg">ॐ</span> भूर्भुवः स्वः तत्सवितुर्वरेण्यं भर्गो देवस्य धीमहि धियो यो नः प्रचोदयात् ॥</span>
                <span class="mx-8 flex items-center gap-2"><span class="text-[#FAF6F0] text-lg">ॐ</span> भूर्भुवः स्वः तत्सवितुर्वरेण्यं भर्गो देवस्य धीमहि धियो यो नः प्रचोदयात् ॥</span>
            </div>
            <div class="animate-marquee flex flex-row items-center" aria-hidden="true">
                <span class="mx-8 flex items-center gap-2"><span class="text-[#FAF6F0] text-lg">ॐ</span> भूर्भुवः स्वः तत्सवितुर्वरेण्यं भर्गो देवस्य धीमहि धियो यो नः प्रचोदयात् ॥</span>
                <span class="mx-8 flex items-center gap-2"><span class="text-[#FAF6F0] text-lg">ॐ</span> भूर्भुवः स्वः तत्सवितुर्वरेण्यं भर्गो देवस्य धीमहि धियो यो नः प्रचोदयात् ॥</span>
                <span class="mx-8 flex items-center gap-2"><span class="text-[#FAF6F0] text-lg">ॐ</span> भूर्भुवः स्वः तत्सवितुर्वरेण्यं भर्गो देवस्य धीमहि धियो यो नः प्रचोदयात् ॥</span>
                <span class="mx-8 flex items-center gap-2"><span class="text-[#FAF6F0] text-lg">ॐ</span> भूर्भुवः स्वः तत्सवितुर्वरेण्यं भर्गो देवस्य धीमहि धियो यो नः प्रचोदयात् ॥</span>
            </div>
        </div>
    </div>

    <style>
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-100%); }
        }
        .animate-marquee {
            animation: marquee 35s linear infinite;
        }
    </style>

    <!-- Footer -->
    <footer class="bg-[#FAF6F0] text-gray-800 border-t border-[#C49A6C]/20 pt-16 sm:pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                
                <!-- About -->
                <div>
                    <h3 class="text-lg font-bold mb-4 font-serif text-gray-900">About Our Store</h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">
                        Welcome to Vedic Botanica – a place where spirituality meets authenticity. We are dedicated to providing genuine, certified, and high-quality premium gou dhoop sticks that bring positivity, balance, and inner peace into your life.
                    </p>
                    <h4 class="text-md font-bold mb-3 font-serif text-gray-900">Follow Us</h4>
                    <div class="flex space-x-3">
                        @php
                            $facebookUrl = $siteSettings['facebook_url'] ?? 'https://www.facebook.com/share/19Dfpv7AfK';
                            $instagramUrl = $siteSettings['instagram_url'] ?? 'https://www.instagram.com/vedicbotanica';
                            $twitterUrl = $siteSettings['twitter_url'] ?? '';
                            $youtubeUrl = $siteSettings['youtube_url'] ?? '';
                        @endphp
                        @if(!empty($facebookUrl))
                            <a href="{{ $facebookUrl }}" target="_blank" class="bg-[#C49A6C]/10 text-[#C49A6C] hover:bg-[#C49A6C] hover:text-white border border-[#C49A6C]/20 h-8 w-8 rounded-full flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-facebook-f text-sm"></i>
                            </a>
                        @endif
                        @if(!empty($instagramUrl))
                            <a href="{{ $instagramUrl }}" target="_blank" class="bg-[#C49A6C]/10 text-[#C49A6C] hover:bg-[#C49A6C] hover:text-white border border-[#C49A6C]/20 h-8 w-8 rounded-full flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-instagram text-sm"></i>
                            </a>
                        @endif
                        @if(!empty($twitterUrl))
                            <a href="{{ $twitterUrl }}" target="_blank" class="bg-[#C49A6C]/10 text-[#C49A6C] hover:bg-[#C49A6C] hover:text-white border border-[#C49A6C]/20 h-8 w-8 rounded-full flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-x-twitter text-sm"></i>
                            </a>
                        @endif
                        @if(!empty($youtubeUrl))
                            <a href="{{ $youtubeUrl }}" target="_blank" class="bg-[#C49A6C]/10 text-[#C49A6C] hover:bg-[#C49A6C] hover:text-white border border-[#C49A6C]/20 h-8 w-8 rounded-full flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-youtube text-sm"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4 font-serif text-gray-900">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ url('/') }}" class="text-gray-600 hover:text-[#C49A6C] text-sm transition-colors">Home</a></li>
                        <li><a href="{{ url('/shop') }}" class="text-gray-600 hover:text-[#C49A6C] text-sm transition-colors">Shop</a></li>
                        <li><a href="{{ route('bundle.builder') }}" class="text-gray-600 hover:text-[#C49A6C] text-sm transition-colors">Premium Combos</a></li>
                        <li><a href="{{ url('/about') }}" class="text-gray-600 hover:text-[#C49A6C] text-sm transition-colors">About Us</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-gray-600 hover:text-[#C49A6C] text-sm transition-colors">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Helpful Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4 font-serif text-gray-900">Helpful Links</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('privacy') }}" class="text-gray-600 hover:text-[#C49A6C] text-sm transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="text-gray-600 hover:text-[#C49A6C] text-sm transition-colors">Terms & Conditions</a></li>
                        <li><a href="{{ route('refund') }}" class="text-gray-600 hover:text-[#C49A6C] text-sm transition-colors">Refund Policy</a></li>
                        <li><a href="{{ route('cancellation') }}" class="text-gray-600 hover:text-[#C49A6C] text-sm transition-colors">Cancellation Policy</a></li>
                        <li><a href="{{ route('shipping') }}" class="text-gray-600 hover:text-[#C49A6C] text-sm transition-colors">Shipping Policy</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-bold mb-4 font-serif text-gray-900">Contact Us</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fa-solid fa-phone mt-1 mr-3 text-[#C49A6C] text-sm"></i>
                            <span class="text-gray-700 text-sm font-medium">+91 92175 30653</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fa-solid fa-envelope mt-1 mr-3 text-[#C49A6C] text-sm"></i>
                            <span class="text-gray-700 text-sm font-medium">info@vedicbotanica.com</span>
                        </li>
                    </ul>
                </div>

            </div>
            
               <div class="border-t border-gray-200 mt-12 pt-8 flex justify-between items-center">
                <p class="text-gray-500 text-sm">&copy; 2026 Vedic Botanica All Right Reserved | Designed by <a href="https://www.vivektech.online/" target="_blank" class="hover:text-[#C49A6C] transition-colors underline font-medium">VivekTech</a></p>
                <style>
                    .whatsapp-float {
                        position: fixed;
                        bottom: 85px;
                        right: 24px;
                        z-index: 9999;
                    }
                    @media (min-width: 768px) {
                        .whatsapp-float {
                            bottom: 24px;
                        }
                    }
                </style>
                <div class="whatsapp-float">
                    <a href="https://wa.me/919217530653" target="_blank" class="bg-green-500 hover:bg-green-600 text-white h-14 w-14 rounded-full flex items-center justify-center shadow-lg transition-transform hover:scale-110">
                        <i class="fa-brands fa-whatsapp text-3xl"></i>
                    </a>
                </div>
            </div>
            
            
        </div>
    </footer>
    
    <!-- Quick View Modal -->
    <div id="quickview-modal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300 opacity-0">
        <div class="bg-white rounded-2xl max-w-4xl w-full overflow-hidden shadow-2xl relative border border-gray-100 flex flex-col md:flex-row transform scale-95 transition-transform duration-300">
            <!-- Close Button -->
            <button id="close-quickview" class="absolute top-4 right-4 text-gray-400 hover:text-gray-900 transition-colors z-20 h-10 w-10 flex items-center justify-center rounded-full bg-gray-50 hover:bg-gray-100"><i class="fa-solid fa-xmark text-lg"></i></button>
            
            <!-- Modal Body Image -->
            <div class="w-full md:w-1/2 bg-gray-50 flex items-center justify-center p-8 relative">
                <img id="qv-image" src="" alt="" class="max-h-80 object-contain">
                <span id="qv-sale-badge" class="absolute top-4 left-4 bg-red-500 text-white text-[10px] uppercase font-bold px-2 py-1 rounded hidden">Sale</span>
            </div>
            
            <!-- Modal Body Content -->
            <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
                <p id="qv-category" class="text-xs text-primary uppercase font-bold tracking-widest mb-1"></p>
                <h2 id="qv-name" class="text-2xl font-serif font-bold text-gray-900 mb-3"></h2>
                
                <div class="mb-4">
                    <span id="qv-price-del" class="text-lg text-gray-400 line-through mr-3 hidden"></span>
                    <span id="qv-price" class="text-2xl font-bold text-primary"></span>
                </div>
                
                <p id="qv-description" class="text-gray-500 text-sm mb-6 leading-relaxed"></p>
                
                <div class="flex flex-col sm:flex-row gap-4 mb-6">
                    <div class="flex items-center border border-gray-200 rounded">
                        <button type="button" id="qv-qty-minus" class="w-10 h-10 text-gray-600 hover:bg-gray-100 transition"><i class="fa-solid fa-minus text-xs"></i></button>
                        <input type="number" id="qv-qty-input" class="w-12 h-10 text-center border-none focus:ring-0 text-sm text-gray-900" value="1" min="1">
                        <button type="button" id="qv-qty-plus" class="w-10 h-10 text-gray-600 hover:bg-gray-100 transition"><i class="fa-solid fa-plus text-xs"></i></button>
                    </div>
                    <button type="button" id="qv-add-to-cart" class="flex-1 bg-primary hover:bg-primary-dark text-white font-bold py-3 rounded tracking-wider text-xs shadow transition-colors" style="background-color: #C49A6C; color: white;">
                        ADD TO CART
                    </button>
                </div>
                
                <a id="qv-view-details" href="" class="text-xs text-center text-gray-500 hover:text-primary transition underline font-medium">View Full Details</a>
            </div>
        </div>
    </div>

    <!-- Premium Toast Notification -->
    <div id="toast-notification" class="fixed bottom-6 left-6 z-50 transform translate-y-20 opacity-0 transition-all duration-300 bg-white border border-gray-150 rounded-lg p-4 shadow-xl flex items-center space-x-3 max-w-sm w-full pointer-events-none">
        <div id="toast-icon-wrapper" class="bg-green-50 text-green-500 p-2 rounded-full flex items-center justify-center">
            <i id="toast-icon" class="fa-solid fa-check text-lg"></i>
        </div>
        <div>
            <p id="toast-message" class="text-sm font-semibold text-gray-900"></p>
        </div>
    </div>

    <!-- Global Javascript handlers -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // --- Global Count Badge Update Helpers ---
            window.updateWishlistBadges = function(count) {
                ['wishlist-count-badge', 'wishlist-count-badge-mobile', 'wishlist-count-badge-mobile-header'].forEach(id => {
                    const badge = document.getElementById(id);
                    if (badge) badge.textContent = count;
                });
            };

            window.updateCartBadges = function(count) {
                ['cart-count-badge', 'cart-count-badge-mobile', 'cart-count-badge-mobile-header'].forEach(id => {
                    const badge = document.getElementById(id);
                    if (badge) badge.textContent = count;
                });
            };

            // --- Toast Notification Handler ---
            window.showToast = function(message, isSuccess = true) {
                const toast = document.getElementById('toast-notification');
                const toastMsg = document.getElementById('toast-message');
                const iconWrapper = document.getElementById('toast-icon-wrapper');
                const icon = document.getElementById('toast-icon');

                toastMsg.textContent = message;

                if (isSuccess) {
                    iconWrapper.className = 'bg-green-50 text-green-500 p-2 rounded-full flex items-center justify-center';
                    icon.className = 'fa-solid fa-check text-lg';
                } else {
                    iconWrapper.className = 'bg-red-50 text-red-500 p-2 rounded-full flex items-center justify-center';
                    icon.className = 'fa-solid fa-exclamation text-lg';
                }

                toast.classList.remove('translate-y-20', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');

                setTimeout(() => {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-20', 'opacity-0');
                }, 3000);
            };
            const showToast = window.showToast;

            // --- Wishlist Handler ---
            document.body.addEventListener('click', function(e) {
                const wishlistBtn = e.target.closest('.btn-wishlist');
                if (wishlistBtn) {
                    const productId = wishlistBtn.getAttribute('data-product-id');
                    
                    fetch('/wishlist/toggle', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ product_id: productId })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Update badge
                            updateWishlistBadges(data.wishlist_count);

                            // Toggle Icon (fa-regular <-> fa-solid)
                            const icon = wishlistBtn.querySelector('i');
                            if (data.in_wishlist) {
                                icon.className = 'fa-solid fa-heart';
                                wishlistBtn.classList.remove('text-gray-800');
                                wishlistBtn.classList.add('text-red-500');
                            } else {
                                icon.className = 'fa-regular fa-heart';
                                wishlistBtn.classList.remove('text-red-500');
                                wishlistBtn.classList.add('text-gray-800');

                                // If we are on the wishlist page itself, remove the card item
                                const card = e.target.closest('.product-wishlist-card');
                                if (card) {
                                    card.remove();
                                    // If no cards left, reload to show empty view
                                    if (document.querySelectorAll('.product-wishlist-card').length === 0) {
                                        location.reload();
                                    }
                                }
                            }
                            showToast(data.message);
                        } else {
                            showToast(data.message || 'Something went wrong.', false);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        showToast('Error connecting to server.', false);
                    });
                }
            });

            // --- Add to Cart Handler (Grid Cards) ---
            document.body.addEventListener('click', function(e) {
                const addCartBtn = e.target.closest('.btn-add-to-cart');
                if (addCartBtn) {
                    const productId = addCartBtn.getAttribute('data-product-id');
                    
                    fetch('/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ product_id: productId, quantity: 1 })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            updateCartBadges(data.cart_count);
                            showToast(data.message);
                        } else {
                            showToast(data.message || 'Could not add to cart.', false);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        showToast('Error connecting to server.', false);
                    });
                }
            });

            // --- Product Details Quantity Controls ---
            const qtyInput = document.getElementById('qty-input');
            const qtyPlus = document.getElementById('qty-plus');
            const qtyMinus = document.getElementById('qty-minus');

            if (qtyPlus && qtyMinus && qtyInput) {
                qtyPlus.addEventListener('click', () => {
                    const max = parseInt(qtyInput.getAttribute('max')) || Infinity;
                    let val = parseInt(qtyInput.value) + 1;
                    if (val > max) val = max;
                    qtyInput.value = val;
                });
                qtyMinus.addEventListener('click', () => {
                    let val = parseInt(qtyInput.value) - 1;
                    if (val < 1) val = 1;
                    qtyInput.value = val;
                });
                qtyInput.addEventListener('change', () => {
                    const max = parseInt(qtyInput.getAttribute('max')) || Infinity;
                    let val = parseInt(qtyInput.value) || 1;
                    if (val < 1) val = 1;
                    if (val > max) val = max;
                    qtyInput.value = val;
                });
            }

            // --- Product Details Add to Cart ---
            const detailAddCart = document.getElementById('detail-add-to-cart');
            if (detailAddCart) {
                detailAddCart.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const qty = qtyInput ? parseInt(qtyInput.value) : 1;

                    fetch('/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ product_id: productId, quantity: qty })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            updateCartBadges(data.cart_count);
                            showToast(data.message);
                        } else {
                            showToast(data.message, false);
                        }
                    })
                    .catch(err => console.error(err));
                });
            }

            // --- Product Details Buy Now ---
            const detailBuyNow = document.getElementById('detail-buy-now');
            if (detailBuyNow) {
                detailBuyNow.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const qty = qtyInput ? parseInt(qtyInput.value) : 1;

                    fetch('/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ product_id: productId, quantity: qty })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = '/cart';
                        } else {
                            showToast(data.message, false);
                        }
                    })
                    .catch(err => console.error(err));
                });
            }

            // --- Quick View Modal Handler ---
            const qvModal = document.getElementById('quickview-modal');
            const qvImage = document.getElementById('qv-image');
            const qvSaleBadge = document.getElementById('qv-sale-badge');
            const qvCategory = document.getElementById('qv-category');
            const qvName = document.getElementById('qv-name');
            const qvPriceDel = document.getElementById('qv-price-del');
            const qvPrice = document.getElementById('qv-price');
            const qvDescription = document.getElementById('qv-description');
            const qvQtyInput = document.getElementById('qv-qty-input');
            const qvAddToCartBtn = document.getElementById('qv-add-to-cart');
            const qvViewDetails = document.getElementById('qv-view-details');
            const closeQvBtn = document.getElementById('close-quickview');

            let activeQvProductId = null;

            // Trigger Quick View
            document.body.addEventListener('click', function(e) {
                const quickViewBtn = e.target.closest('.btn-quickview');
                if (quickViewBtn) {
                    const slug = quickViewBtn.getAttribute('data-product-slug');
                    
                    fetch('/api/product/' + slug)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            const p = data.product;
                            activeQvProductId = p.id;

                            // Populate details
                            qvImage.src = p.image;
                            qvImage.alt = p.name;
                            qvCategory.textContent = p.category_name;
                            qvName.textContent = p.name;
                            qvDescription.textContent = p.short_description || p.description;
                            qvQtyInput.value = 1;
                            qvQtyInput.setAttribute('max', p.quantity);

                            // Price displaying
                            if (p.sale_price) {
                                qvPriceDel.textContent = '₹' + parseFloat(p.price).toFixed(2);
                                qvPriceDel.classList.remove('hidden');
                                qvPrice.textContent = '₹' + parseFloat(p.sale_price).toFixed(2);
                                qvSaleBadge.classList.remove('hidden');
                            } else {
                                qvPriceDel.classList.add('hidden');
                                qvPrice.textContent = '₹' + parseFloat(p.price).toFixed(2);
                                qvSaleBadge.classList.add('hidden');
                            }

                            // View detail link
                            qvViewDetails.href = '/product/' + p.slug;

                            // Open Modal
                            qvModal.classList.remove('hidden');
                            setTimeout(() => {
                                qvModal.classList.remove('opacity-0');
                                qvModal.classList.add('opacity-100');
                                qvModal.querySelector('div').classList.remove('scale-95');
                                qvModal.querySelector('div').classList.add('scale-100');
                            }, 50);
                        } else {
                            showToast('Failed to load product details.', false);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        showToast('Error connecting to server.', false);
                    });
                }
            });

            // Close Quick View
            function closeQuickView() {
                qvModal.classList.remove('opacity-100');
                qvModal.classList.add('opacity-0');
                qvModal.querySelector('div').classList.remove('scale-100');
                qvModal.querySelector('div').classList.add('scale-95');
                setTimeout(() => {
                    qvModal.classList.add('hidden');
                }, 300);
            }

            if (closeQvBtn) closeQvBtn.addEventListener('click', closeQuickView);
            if (qvModal) {
                qvModal.addEventListener('click', function(e) {
                    if (e.target === qvModal) closeQuickView();
                });
            }

            // Modal Quantity controls
            const qvQtyPlus = document.getElementById('qv-qty-plus');
            const qvQtyMinus = document.getElementById('qv-qty-minus');
            if (qvQtyPlus && qvQtyMinus && qvQtyInput) {
                qvQtyPlus.addEventListener('click', () => {
                    const max = parseInt(qvQtyInput.getAttribute('max')) || Infinity;
                    let val = parseInt(qvQtyInput.value) + 1;
                    if (val > max) val = max;
                    qvQtyInput.value = val;
                });
                qvQtyMinus.addEventListener('click', () => {
                    let val = parseInt(qvQtyInput.value) - 1;
                    if (val < 1) val = 1;
                    qvQtyInput.value = val;
                });
                qvQtyInput.addEventListener('change', () => {
                    const max = parseInt(qvQtyInput.getAttribute('max')) || Infinity;
                    let val = parseInt(qvQtyInput.value) || 1;
                    if (val < 1) val = 1;
                    if (val > max) val = max;
                    qvQtyInput.value = val;
                });
            }

            // Modal Add to Cart
            if (qvAddToCartBtn) {
                qvAddToCartBtn.addEventListener('click', function() {
                    if (!activeQvProductId) return;
                    const qty = qvQtyInput ? parseInt(qvQtyInput.value) : 1;

                    fetch('/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ product_id: activeQvProductId, quantity: qty })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            updateCartBadges(data.cart_count);
                            showToast(data.message);
                            closeQuickView();
                        } else {
                            showToast(data.message, false);
                        }
                    })
                    .catch(err => console.error(err));
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
