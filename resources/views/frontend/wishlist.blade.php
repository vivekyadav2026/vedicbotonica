@extends('layouts.frontend')

@section('title', 'My Wishlist')

@section('content')
    <!-- Page Header (Premium Banner Style) -->
    <div class="relative bg-gradient-to-br from-[#FAF6F0] via-white to-[#FAF6F0] py-16 md:py-24 border-b border-[#C49A6C]/20 overflow-hidden text-center animate-fade-in">
        <!-- Background Banner Image with Subtle Overlay -->
        <div class="absolute inset-0 opacity-[0.25] mix-blend-overlay bg-cover bg-center bg-no-repeat pointer-events-none" style="background-image: url('{{ asset('images/about_hero_banner.png') }}');"></div>
        <!-- Decorative subtle golden circular glow -->
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#C49A6C]/5 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <p class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-[0.25em] font-sans">
                <a href="{{ url('/') }}" class="hover:text-[#C49A6C] transition-colors">Home</a> 
                <span class="mx-2 text-[#C49A6C]">•</span> 
                <span class="text-gray-900 font-medium">Wishlist</span>
            </p>
            <h1 class="text-3xl sm:text-5xl font-serif font-bold text-gray-955 uppercase tracking-widest mt-3">My Wishlist</h1>
            <p class="text-[10px] text-[#C49A6C] uppercase font-bold tracking-widest font-serif mt-2">Your Spiritual Favourites</p>
            <div class="w-16 h-[1.5px] bg-[#C49A6C] mx-auto mt-4"></div>
        </div>
    </div>

    <!-- Wishlist Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
                @foreach($products as $product)
                <div class="group border border-[#C49A6C]/60 bg-[#FAF6F0] rounded-[1.25rem] sm:rounded-[1.5rem] p-3 sm:p-4 transition-all duration-300 hover:shadow-xl flex flex-col h-full product-wishlist-card" data-id="{{ $product->id }}">
                    <div class="w-full bg-white rounded-[1rem] flex items-center justify-center relative overflow-hidden aspect-square border border-gray-100">
                        <!-- Product Image -->
                        @php
                            $images = json_decode($product->images);
                            $image = ($images && count($images) > 0) ? asset($images[0]) : 'https://images.unsplash.com/photo-1599643478524-fb5244098775?w=500&q=80';
                        @endphp
                        <a href="/product/{{ $product->slug }}" class="w-full h-full flex items-center justify-center">
                            <img src="{{ $image }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain">
                        </a>
                        
                        <!-- Sale Badge -->
                        @if($product->sale_price)
                        @php
                            $discountPercent = round((($product->price - $product->sale_price) / $product->price) * 100);
                        @endphp
                        <div class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-red-500 text-white text-[8px] sm:text-[9px] uppercase font-bold px-1.5 py-0.5 rounded z-10">{{ $discountPercent }}% OFF</div>
                        @endif
                        
                        <!-- Right Icons -->
                        <div class="flex flex-col space-y-1.5 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-300 z-10" style="position: absolute; top: 8px; right: 8px; sm:top: 12px; sm:right: 12px; left: auto;">
                            <button class="bg-white text-red-500 p-1.5 sm:p-2 rounded-full shadow-md border border-gray-100 hover:text-red-650 hover:bg-gray-50 transition w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-[10px] sm:text-xs btn-wishlist" data-product-id="{{ $product->id }}" title="Remove from Wishlist"><i class="fa-solid fa-heart"></i></button>
                            <button class="bg-white text-gray-800 p-1.5 sm:p-2 rounded-full shadow-md border border-gray-100 hover:text-primary hover:bg-gray-50 transition w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-[10px] sm:text-xs btn-quickview" data-product-slug="{{ $product->slug }}" title="Quick View"><i class="fa-regular fa-eye"></i></button>
                            <button class="bg-white text-gray-800 p-1.5 sm:p-2 rounded-full shadow-md border border-gray-100 hover:text-primary hover:bg-gray-50 transition w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-[10px] sm:text-xs btn-add-to-cart md:hidden" data-product-id="{{ $product->id }}" title="Add to Cart">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </div>
                        
                        <!-- Add to Cart Overlay -->
                        <div class="absolute bottom-0 left-0 right-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-10 hidden md:block">
                            <button class="w-full bg-[#D2B48C] hover:bg-[#C49A6C] text-white font-semibold py-3.5 tracking-wider text-xs uppercase btn-add-to-cart transition-colors duration-300 cursor-pointer" style="background-color: #D2B48C; color: white;" data-product-id="{{ $product->id }}">ADD TO CART</button>
                        </div>
                    </div>
                    
                    <div class="pt-3 sm:pt-4 text-left flex-1 flex flex-col justify-between">
                        <h3 class="text-xs sm:text-[15px] font-sans font-medium text-gray-800 leading-snug line-clamp-1">
                            <a href="/product/{{ $product->slug }}" class="hover:text-[#C49A6C] transition">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="text-[10px] sm:text-[11px] text-gray-400 line-clamp-1 font-sans font-normal leading-normal mt-1">{{ $product->short_description }}</p>
                        @if($product->sale_price)
                        @php
                            $discountPercent = round((($product->price - $product->sale_price) / $product->price) * 100);
                        @endphp
                        <div class="flex items-center space-x-1.5 sm:space-x-2 mt-1 flex-wrap">
                            <p class="text-sm sm:text-[17px] font-bold text-[#C49A6C]">₹{{ number_format($product->sale_price) }}</p>
                            <p class="text-[10px] sm:text-xs font-medium text-gray-400 line-through">₹{{ number_format($product->price) }}</p>
                            <span class="text-[10px] text-red-500 font-bold font-sans">({{ $discountPercent }}% Off)</span>
                        </div>
                        @else
                        <p class="text-sm sm:text-[17px] font-bold text-[#C49A6C] mt-1">₹{{ number_format($product->price) }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 bg-[#fdfaf6] rounded-xl border border-dashed border-gray-300">
                <i class="fa-regular fa-heart text-6xl text-gray-300 mb-6"></i>
                <h2 class="text-2xl font-serif font-bold text-gray-900 mb-2">Your Wishlist is Empty</h2>
                <p class="text-gray-500 mb-8 max-w-sm mx-auto">Add items that you like to your wishlist so you can find them easily later.</p>
                <a href="/shop" class="inline-block bg-primary hover:bg-primary-dark text-white font-bold px-8 py-4 rounded tracking-wider text-sm transition shadow" style="background-color: #C49A6C; color: white;">
                    BROWSE PRODUCTS
                </a>
            </div>
        @endif
    </div>
@endsection
