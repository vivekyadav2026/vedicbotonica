@extends('layouts.frontend')

@section('title', 'Home')

@section('content')
    <!-- Hero Banner Slider -->
    @php
        $sliderBanners = $banners->where('is_active', true)->values();
        $fallbackImage = asset('images/modern_banner_new.png');
    @endphp

    <style>
        .banner-slider-container {
            position: relative;
            width: 100%;
            overflow: hidden;
        }
        .banner-track {
            display: flex;
            transition: transform 0.7s ease-in-out;
            width: 100%;
        }
        .banner-slide {
            position: relative;
            width: 100%;
            flex-shrink: 0;
        }
        .banner-slide img {
            width: 100%;
            height: auto;
            display: block;
        }
        .banner-arrow-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 40;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: rgba(196, 154, 108, 0.9) !important; /* Golden Brand color */
            border: 2px solid #ffffff !important;
            color: #ffffff !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }
        .banner-arrow-btn:hover {
            background-color: #b0875b !important;
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
        }
        .banner-arrow-btn:active {
            transform: translateY(-50%) scale(0.95);
        }
        .banner-arrow-prev {
            left: 20px;
        }
        .banner-arrow-next {
            right: 20px;
        }
        .banner-dots-wrapper {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 40;
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .banner-dot-indicator {
            height: 10px;
            border-radius: 9999px;
            border: 1.5px solid #ffffff;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .banner-dot-indicator.inactive {
            width: 10px;
            background-color: rgba(255, 255, 255, 0.5);
        }
        .banner-dot-indicator.active {
            width: 30px;
            background-color: #C49A6C;
            border-color: #C49A6C;
        }
        @media (max-width: 640px) {
            .banner-arrow-btn {
                width: 32px;
                height: 32px;
            }
            .banner-arrow-prev {
                left: 10px;
            }
            .banner-arrow-next {
                right: 10px;
            }
            .banner-arrow-btn svg {
                width: 16px;
                height: 16px;
            }
        }
    </style>

    @if($sliderBanners->isEmpty())
        {{-- Fallback: show default banner image --}}
        <div class="w-full">
            <img class="w-full h-auto block" src="{{ $fallbackImage }}" alt="Vedic Botanica Hero Banner">
        </div>
    @else
    {{-- Banner Slider --}}
    <div class="banner-slider-container" id="bannerSlider">

        {{-- Slides Track --}}
        <div class="banner-track" id="bannerTrack">
            @foreach($sliderBanners as $banner)
            <div class="banner-slide">
                @if($banner->link)
                    <a href="{{ $banner->link }}" class="block w-full">
                @endif
                    <img
                        src="{{ asset($banner->image_path) }}"
                        alt="{{ $banner->title ?? 'Vedic Botanica Banner' }}"
                        loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                    >
                @if($banner->link)
                    </a>
                @endif
            </div>
            @endforeach
        </div>

        @if($sliderBanners->count() > 1)
        {{-- Prev Arrow --}}
        <button
            id="bannerPrev"
            class="banner-arrow-btn banner-arrow-prev"
            aria-label="Previous banner"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;">
                <path d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        {{-- Next Arrow --}}
        <button
            id="bannerNext"
            class="banner-arrow-btn banner-arrow-next"
            aria-label="Next banner"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;">
                <path d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        {{-- Dots Navigation --}}
        <div class="banner-dots-wrapper" id="bannerDots">
            @foreach($sliderBanners as $i => $banner)
            <button
                aria-label="Go to slide {{ $i + 1 }}"
                class="banner-dot-indicator {{ $i === 0 ? 'active' : 'inactive' }}"
                data-index="{{ $i }}"
            ></button>
            @endforeach
        </div>
        @endif
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const total = {{ $sliderBanners->count() }};
        if (total <= 1) return;

        const track   = document.getElementById('bannerTrack');
        const dots    = document.querySelectorAll('.banner-dot-indicator');
        const prevBtn = document.getElementById('bannerPrev');
        const nextBtn = document.getElementById('bannerNext');
        let current   = 0;
        let timer;

        function goTo(index) {
            current = (index + total) % total;
            track.style.transform = `translateX(-${current * 100}%)`;
            dots.forEach((d, i) => {
                if (i === current) {
                    d.classList.remove('inactive');
                    d.classList.add('active');
                } else {
                    d.classList.remove('active');
                    d.classList.add('inactive');
                }
            });
        }

        function startAuto() {
            clearInterval(timer);
            timer = setInterval(() => goTo(current + 1), 4000);
        }

        prevBtn.addEventListener('click', () => { goTo(current - 1); startAuto(); });
        nextBtn.addEventListener('click', () => { goTo(current + 1); startAuto(); });
        dots.forEach(d => d.addEventListener('click', () => { goTo(+d.dataset.index); startAuto(); }));

        // Touch / swipe support
        let startX = 0;
        track.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
        track.addEventListener('touchend',   e => {
            const diff = startX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 40) { goTo(current + (diff > 0 ? 1 : -1)); startAuto(); }
        });

        startAuto();
    });
    </script>
    @endif


   

    <!-- Shop by Category Section -->
    <div id="shop-by-category" class="bg-gradient-to-b from-[#FAF6F0]/40 to-white pt-8 pb-4 border-b border-gray-100 relative overflow-hidden">
        <!-- Subtle background glow -->
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#C49A6C]/2 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-xl mx-auto mb-12">
                <span class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest bg-[#C49A6C]/10 px-3.5 py-1.5 rounded-full font-serif">Sacred Elements</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900 mt-4">Shop By Category</h2>
                <!-- Mandalic/Ayurvedic Divider in SVG -->
                <div class="flex items-center justify-center space-x-4 mt-3">
                    <div class="w-16 h-[1px] bg-gradient-to-r from-transparent to-[#C49A6C]"></div>
                    <svg class="w-6 h-6 text-[#C49A6C]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" stroke-dasharray="2 2" />
                        <path d="M12 6c-1.5 2.5-3 5.5-3 8 0 2.5 1.5 4 3 4s3-1.5 3-4c0-2.5-1.5-5.5-3-8z" fill="currentColor" fill-opacity="0.15" />
                        <path d="M12 10c-3 1-5 3.5-5 6 0 1 1 2 2 2s3-1.5 3-3V10z" />
                        <path d="M12 10c3 1 5 3.5 5 6 0 1-1 2-2 2s-3-1.5-3-3V10z" />
                    </svg>
                    <div class="w-16 h-[1px] bg-gradient-to-l from-transparent to-[#C49A6C]"></div>
                </div>
            </div>

            @if($categories->isEmpty())
                <p class="text-gray-400 text-sm font-sans text-center">No categories found.</p>
            @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8 max-w-7xl mx-auto">
                @foreach($categories as $category)
                @php
                    $catImage = $category->image ? asset($category->image) : asset('images/premium_dhoop_product.png');
                    $catLink = '/shop?categories[]=' . $category->id;
                @endphp
                <a href="{{ $catLink }}" class="group relative bg-white border border-[#C49A6C]/20 rounded-3xl p-3 sm:p-4 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(196,154,108,0.15)] hover:border-[#C49A6C] hover:-translate-y-1.5 flex flex-col h-full overflow-hidden">
                    <!-- Image container: Aspect ratio filled completely to remove white gaps -->
                    <div class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden border border-gray-150 shadow-xs">
                        <img src="{{ $catImage }}" alt="{{ $category->name }}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-108">
                    </div>
                    
                    <!-- Content details matching product cards -->
                    <div class="pt-3 sm:pt-4 text-left flex-1 flex flex-col justify-between">
                        <div class="space-y-1">
                            <span class="text-[9px] sm:text-[10px] text-[#C49A6C] uppercase font-bold tracking-widest block font-serif">Sacred Category</span>
                            <h3 class="text-xs sm:text-sm font-serif font-bold text-gray-900 group-hover:text-[#C49A6C] transition-colors leading-snug line-clamp-1">
                                {{ $category->name }}
                            </h3>
                        </div>
                        
                        <div class="pt-2 flex items-center justify-between border-t border-[#FAF6F0] mt-3">
                            <span class="text-[10px] font-sans font-bold text-[#C49A6C] uppercase tracking-wider group-hover:translate-x-1.5 transition-transform duration-300">
                                Explore <i class="fa-solid fa-arrow-right ml-1 text-[8px]"></i>
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>


      <!-- Best Selling Products -->
    <div class="bg-white pt-6 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-10">
                <span class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest bg-[#C49A6C]/10 px-3.5 py-1.5 rounded-full font-serif">Customer Favorites</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900 mt-4">Best Selling Products</h2>
                <div class="w-16 h-1 bg-[#C49A6C] mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
                @foreach($bestSellers as $product)
                @php
                    $inWishlist = in_array($product->id, session()->get('wishlist', []));
                @endphp
                <div class="group relative bg-white border border-[#C49A6C]/20 rounded-3xl p-3 sm:p-4 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(196,154,108,0.15)] hover:border-[#C49A6C] hover:-translate-y-1.5 flex flex-col h-full overflow-hidden">
                    <!-- Image container -->
                    <div class="relative w-full aspect-square bg-gradient-to-br from-[#FAF6F0]/60 to-white rounded-2xl overflow-hidden flex items-center justify-center border border-gray-100/50">
                        @php
                            $images = json_decode($product->images);
                            $image = ($images && count($images) > 0) ? asset($images[0]) : asset('images/premium_dhoop_product.png');
                        @endphp
                        <a href="/product/{{ $product->slug }}" class="w-full h-full flex items-center justify-center">
                            <img src="{{ $image }}" alt="{{ $product->name }}" class="max-h-[85%] max-w-[85%] object-contain transition-transform duration-700 ease-out group-hover:scale-108">
                        </a>

                        <!-- Badges -->
                        <div class="absolute top-2.5 left-2.5 flex flex-col gap-1 z-10">
                            @if($product->sale_price)
                                @php
                                    $discountPercent = round((($product->price - $product->sale_price) / $product->price) * 100);
                                @endphp
                                <span class="bg-red-500 border border-white text-white text-[9px] font-bold px-2 py-0.5 rounded-full shadow-md uppercase tracking-wider">{{ $discountPercent }}% OFF</span>
                            @endif
                        </div>

                        <!-- Floating Quick Action Buttons -->
                        <div class="absolute top-2.5 right-2.5 flex flex-col gap-1.5 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-all duration-300 transform translate-x-0 md:translate-x-4 md:group-hover:translate-x-0 z-10">
                            <button class="bg-white/80 backdrop-blur-md {{ $inWishlist ? 'text-red-500 border-red-200' : 'text-gray-800 border-[#C49A6C]/20' }} hover:text-white hover:bg-[#C49A6C] p-2 rounded-full shadow-md border transition w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-xs btn-wishlist cursor-pointer" data-product-id="{{ $product->id }}" title="Add to Wishlist">
                                <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                            </button>
                            <button class="bg-white/80 backdrop-blur-md text-gray-800 hover:text-white hover:bg-[#C49A6C] p-2 rounded-full shadow-md border border-[#C49A6C]/20 transition w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-xs btn-quickview cursor-pointer" data-product-slug="{{ $product->slug }}" title="Quick View">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>

                        <!-- Desktop Add to Cart Overlay -->
                        <div class="absolute bottom-0 left-0 right-0 translate-y-full group-hover:translate-y-0 transition-all duration-500 z-10 hidden md:block">
                            <button class="w-full bg-gradient-to-r from-[#C49A6C] to-[#b0875b] hover:from-[#b0875b] hover:to-[#9a734c] text-white font-serif font-medium py-3.5 tracking-wider text-xs uppercase btn-add-to-cart transition-all duration-300 cursor-pointer shadow-lg active:scale-95 flex items-center justify-center gap-2" data-product-id="{{ $product->id }}">
                                <i class="fa-solid fa-cart-plus mr-1"></i> Add To Cart
                            </button>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="pt-3 sm:pt-4 flex-1 flex flex-col justify-between">
                        <div class="space-y-1">
                            <h3 class="text-xs sm:text-sm font-serif font-bold text-gray-900 hover:text-[#C49A6C] transition-colors leading-snug line-clamp-1">
                                <a href="/product/{{ $product->slug }}">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 line-clamp-1 font-sans font-normal leading-normal">{{ $product->short_description }}</p>
                        </div>

                        <div class="pt-2 flex items-center justify-between border-t border-[#FAF6F0] mt-3">
                            <!-- Price -->
                            <div>
                                @if($product->sale_price)
                                    @php
                                        $discountPercent = round((($product->price - $product->sale_price) / $product->price) * 100);
                                    @endphp
                                    <div class="flex items-baseline space-x-1.5 flex-wrap">
                                        <span class="text-sm sm:text-base font-serif font-bold text-gray-900">₹{{ number_format($product->sale_price) }}</span>
                                        <span class="text-[10px] sm:text-xs text-gray-400 line-through">₹{{ number_format($product->price) }}</span>
                                        <span class="text-[10px] text-red-500 font-bold font-sans">({{ $discountPercent }}% Off)</span>
                                    </div>
                                @else
                                    <span class="text-sm sm:text-base font-serif font-bold text-gray-900">₹{{ number_format($product->price) }}</span>
                                @endif
                            </div>

                            <!-- Mobile Add to Cart Button -->
                            <button class="md:hidden bg-[#C49A6C]/10 border border-[#C49A6C]/20 hover:bg-[#C49A6C] text-[#C49A6C] hover:text-white p-2 rounded-xl transition-all duration-300 w-9 h-9 flex items-center justify-center btn-add-to-cart cursor-pointer active:scale-90" data-product-id="{{ $product->id }}" title="Add to Cart">
                                <i class="fa-solid fa-cart-plus text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- View All Products CTA -->
            <div class="text-center mt-8">
                <a href="/shop" class="group inline-flex items-center space-x-2 border border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white font-serif font-bold px-8 py-3.5 rounded-xl tracking-wider text-xs uppercase transition-all duration-300 shadow-xs hover:shadow-md transform hover:-translate-y-0.5">
                    <span>Explore All Products</span>
                    <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
            </div>
        </div>
    </div>


    <!-- Deal of the Week Spotlight -->
    @if($dealOfWeek)
    @php
        $dealImages = json_decode($dealOfWeek->images);
        $dealImage = ($dealImages && count($dealImages) > 0) ? asset($dealImages[0]) : asset('images/premium_dhoop_product.png');
        $inWishlist = in_array($dealOfWeek->id, session()->get('wishlist', []));
    @endphp
    <div class="bg-[#FAF6F0]/30 py-12 border-t border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-[#C49A6C]/20 shadow-[0_15px_45px_rgba(196,154,108,0.1)] overflow-hidden p-6 sm:p-10 lg:p-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- Left: Product Image -->
                    <div class="lg:col-span-5 flex justify-center relative bg-[#FAF6F0]/40 rounded-2xl p-6 sm:p-10 border border-gray-100 group">
                        <span class="absolute top-4 left-4 bg-[#e05638] text-white text-[9px] uppercase font-bold px-2.5 py-1 rounded-md shadow z-10 tracking-wider">Limited Time Offer</span>
                        <a href="/product/{{ $dealOfWeek->slug }}" class="w-full h-full flex justify-center items-center">
                            <img src="{{ $dealImage }}" alt="{{ $dealOfWeek->name }}" class="max-h-[300px] sm:max-h-[350px] object-contain transition-transform duration-500 group-hover:scale-103">
                        </a>
                    </div>
                    
                    <!-- Right: Deal Details -->
                    <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                        <span class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest bg-[#C49A6C]/10 px-3.5 py-1.5 rounded-full inline-block">⏳ Deal of the Week</span>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-bold text-gray-900 leading-tight">
                            <a href="/product/{{ $dealOfWeek->slug }}" class="hover:text-[#C49A6C] transition">{{ $dealOfWeek->name }}</a>
                        </h2>
                        
                        <!-- Rating -->
                        <div class="flex items-center justify-center lg:justify-start space-x-1.5 text-yellow-400 text-sm">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            <span class="text-gray-500 font-sans text-xs ml-2">(4.9/5 Rating)</span>
                        </div>

                        <p class="text-sm sm:text-base text-gray-600 leading-relaxed font-sans max-w-2xl mx-auto lg:mx-0">
                            {{ $dealOfWeek->short_description ?? 'Purify your space with our premium hand-rolled dhoop sticks, made using ancient Ayurvedic traditions.' }}
                        </p>

                        <!-- Price display -->
                        <div class="flex items-center justify-center lg:justify-start space-x-4">
                            @if($dealOfWeek->sale_price)
                                <span class="text-3xl lg:text-4xl font-extrabold text-gray-950">₹{{ number_format($dealOfWeek->sale_price) }}</span>
                                <span class="text-lg text-gray-400 line-through">₹{{ number_format($dealOfWeek->price) }}</span>
                            @else
                                <span class="text-3xl lg:text-4xl font-extrabold text-gray-955">₹{{ number_format($dealOfWeek->price) }}</span>
                            @endif
                        </div>

                        <!-- Countdown Timer -->
                        <div class="space-y-3">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Hurry up! Offer ends in:</p>
                            <div class="flex items-center space-x-3 justify-center lg:justify-start" id="deal-countdown" data-end-time="{{ now()->addDays(4)->endOfDay()->toIso8601String() }}">
                                <div class="bg-[#FAF6F0] px-4 py-3 rounded-xl border border-[#C49A6C]/20 text-center min-w-[70px] shadow-xs">
                                    <span class="block text-2xl font-bold text-gray-900" id="cd-days">00</span>
                                    <span class="text-[9px] uppercase tracking-wider text-gray-400 font-bold font-sans">Days</span>
                                </div>
                                <div class="bg-[#FAF6F0] px-4 py-3 rounded-xl border border-[#C49A6C]/20 text-center min-w-[70px] shadow-xs">
                                    <span class="block text-2xl font-bold text-gray-900" id="cd-hours">00</span>
                                    <span class="text-[9px] uppercase tracking-wider text-gray-400 font-bold font-sans">Hours</span>
                                </div>
                                <div class="bg-[#FAF6F0] px-4 py-3 rounded-xl border border-[#C49A6C]/20 text-center min-w-[70px] shadow-xs">
                                    <span class="block text-2xl font-bold text-gray-900" id="cd-minutes">00</span>
                                    <span class="text-[9px] uppercase tracking-wider text-gray-400 font-bold font-sans">Mins</span>
                                </div>
                                <div class="bg-[#FAF6F0] px-4 py-3 rounded-xl border border-[#C49A6C]/20 text-center min-w-[70px] shadow-xs">
                                    <span class="block text-2xl font-bold text-[#C49A6C]" id="cd-seconds">00</span>
                                    <span class="text-[9px] uppercase tracking-wider text-gray-400 font-bold font-sans">Secs</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-3 justify-center lg:justify-start">
                            <button type="button" class="bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold h-12 px-8 rounded-xl transition-all duration-300 tracking-wider text-xs uppercase cursor-pointer btn-add-to-cart shadow-md hover:shadow-[#C49A6C]/20 transform hover:-translate-y-0.5" data-product-id="{{ $dealOfWeek->id }}">
                                Add To Cart
                            </button>
                            <a href="/product/{{ $dealOfWeek->slug }}" class="border border-[#C49A6C] text-[#C49A6C] hover:bg-[#FAF6F0]/50 font-bold h-12 px-8 rounded-xl transition-all duration-300 tracking-wider text-xs uppercase flex items-center justify-center transform hover:-translate-y-0.5">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif





    <!-- Featured Healing Essentials -->
    @if(isset($featuredProducts) && count($featuredProducts) > 0)
    <div class="bg-white pt-6 pb-10 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-10">
                <span class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest bg-[#C49A6C]/10 px-3.5 py-1.5 rounded-full block mx-auto w-fit mb-3 font-serif">Pure & Divine</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900 mt-4">Featured Products</h2>
                <div class="w-16 h-1 bg-[#C49A6C] mx-auto mt-4 mb-3 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
                @foreach($featuredProducts as $product)
                @php
                    $inWishlist = in_array($product->id, session()->get('wishlist', []));
                @endphp
                <div class="group relative bg-white border border-[#C49A6C]/20 rounded-3xl p-3 sm:p-4 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(196,154,108,0.15)] hover:border-[#C49A6C] hover:-translate-y-1.5 flex flex-col h-full overflow-hidden">
                    <!-- Image container -->
                    <div class="relative w-full aspect-square bg-gradient-to-br from-[#FAF6F0]/60 to-white rounded-2xl overflow-hidden flex items-center justify-center border border-gray-100/50">
                        @php
                            $images = json_decode($product->images);
                            $image = ($images && count($images) > 0) ? asset($images[0]) : asset('images/premium_dhoop_product.png');
                        @endphp
                        <a href="/product/{{ $product->slug }}" class="w-full h-full flex items-center justify-center">
                            <img src="{{ $image }}" alt="{{ $product->name }}" class="max-h-[85%] max-w-[85%] object-contain transition-transform duration-700 ease-out group-hover:scale-108">
                        </a>

                        <!-- Badges -->
                        <div class="absolute top-2.5 left-2.5 flex flex-col gap-1 z-10">
                            @if($product->sale_price)
                                @php
                                    $discountPercent = round((($product->price - $product->sale_price) / $product->price) * 100);
                                @endphp
                                <span class="bg-red-500 border border-white text-white text-[9px] font-bold px-2 py-0.5 rounded-full shadow-md uppercase tracking-wider">{{ $discountPercent }}% OFF</span>
                            @endif
                        </div>

                        <!-- Floating Quick Action Buttons -->
                        <div class="absolute top-2.5 right-2.5 flex flex-col gap-1.5 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-all duration-300 transform translate-x-0 md:translate-x-4 md:group-hover:translate-x-0 z-10">
                            <button class="bg-white/80 backdrop-blur-md {{ $inWishlist ? 'text-red-500 border-red-200' : 'text-gray-800 border-[#C49A6C]/20' }} hover:text-white hover:bg-[#C49A6C] p-2 rounded-full shadow-md border transition w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-xs btn-wishlist cursor-pointer" data-product-id="{{ $product->id }}" title="Add to Wishlist">
                                <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                            </button>
                            <button class="bg-white/80 backdrop-blur-md text-gray-800 hover:text-white hover:bg-[#C49A6C] p-2 rounded-full shadow-md border border-[#C49A6C]/20 transition w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-xs btn-quickview cursor-pointer" data-product-slug="{{ $product->slug }}" title="Quick View">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>

                        <!-- Desktop Add to Cart Overlay -->
                        <div class="absolute bottom-0 left-0 right-0 translate-y-full group-hover:translate-y-0 transition-all duration-500 z-10 hidden md:block">
                            <button class="w-full bg-gradient-to-r from-[#C49A6C] to-[#b0875b] hover:from-[#b0875b] hover:to-[#9a734c] text-white font-serif font-medium py-3.5 tracking-wider text-xs uppercase btn-add-to-cart transition-all duration-300 cursor-pointer shadow-lg active:scale-95 flex items-center justify-center gap-2" data-product-id="{{ $product->id }}">
                                <i class="fa-solid fa-cart-plus mr-1"></i> Add To Cart
                            </button>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="pt-3 sm:pt-4 flex-1 flex flex-col justify-between">
                        <div class="space-y-1">
                            <h3 class="text-xs sm:text-sm font-serif font-bold text-gray-900 hover:text-[#C49A6C] transition-colors leading-snug line-clamp-1">
                                <a href="/product/{{ $product->slug }}">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 line-clamp-1 font-sans font-normal leading-normal">{{ $product->short_description }}</p>
                        </div>

                        <div class="pt-2 flex items-center justify-between border-t border-[#FAF6F0] mt-3">
                            <!-- Price -->
                            <div>
                                @if($product->sale_price)
                                    @php
                                        $discountPercent = round((($product->price - $product->sale_price) / $product->price) * 100);
                                    @endphp
                                    <div class="flex items-baseline space-x-1.5 flex-wrap">
                                        <span class="text-sm sm:text-base font-serif font-bold text-gray-900">₹{{ number_format($product->sale_price) }}</span>
                                        <span class="text-[10px] sm:text-xs text-gray-400 line-through">₹{{ number_format($product->price) }}</span>
                                        <span class="text-[10px] text-red-500 font-bold font-sans">({{ $discountPercent }}% Off)</span>
                                    </div>
                                @else
                                    <span class="text-sm sm:text-base font-serif font-bold text-gray-900">₹{{ number_format($product->price) }}</span>
                                @endif
                            </div>

                            <!-- Mobile Add to Cart Button -->
                            <button class="md:hidden bg-[#C49A6C]/10 border border-[#C49A6C]/20 hover:bg-[#C49A6C] text-[#C49A6C] hover:text-white p-2 rounded-xl transition-all duration-300 w-9 h-9 flex items-center justify-center btn-add-to-cart cursor-pointer active:scale-90" data-product-id="{{ $product->id }}" title="Add to Cart">
                                <i class="fa-solid fa-cart-plus text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- View All Products CTA -->
            <div class="text-center mt-8">
                <a href="/shop" class="group inline-flex items-center space-x-2 border border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white font-serif font-bold px-8 py-3.5 rounded-xl tracking-wider text-xs uppercase transition-all duration-300 shadow-xs hover:shadow-md transform hover:-translate-y-0.5">
                    <span>Explore All Products</span>
                    <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
            </div>
        </div>
    </div>
    @endif


       <!-- Ingredients Showcase Section -->
    <div class="bg-gradient-to-b from-white via-[#FAF6F0]/40 to-white pt-8 pb-10 border-t border-b border-gray-100 relative overflow-hidden">
        <!-- Center glowing spot -->
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#C49A6C]/3 rounded-full blur-3xl pointer-events-none z-0"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest bg-[#C49A6C]/10 px-3.5 py-1.5 rounded-full font-serif">Nature's Pharmacy</span>
            <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900 mt-4">Pure & Sacred Ingredients</h2>
            
            <!-- Mandalic/Ayurvedic Divider in SVG -->
            <div class="flex items-center justify-center space-x-4 mt-3 mb-8">
                <div class="w-16 h-[1px] bg-gradient-to-r from-transparent to-[#C49A6C]"></div>
                <svg class="w-6 h-6 text-[#C49A6C]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" stroke-dasharray="2 2" />
                    <path d="M12 6c-1.5 2.5-3 5.5-3 8 0 2.5 1.5 4 3 4s3-1.5 3-4c0-2.5-1.5-5.5-3-8z" fill="currentColor" fill-opacity="0.15" />
                    <path d="M12 10c-3 1-5 3.5-5 6 0 1 1 2 2 2s3-1.5 3-3V10z" />
                    <path d="M12 10c3 1 5 3.5 5 6 0 1-1 2-2 2s-3-1.5-3-3V10z" />
                </svg>
                <div class="w-16 h-[1px] bg-gradient-to-l from-transparent to-[#C49A6C]"></div>
            </div>
            
            <p class="text-sm sm:text-base text-gray-500 max-w-lg mx-auto font-sans leading-relaxed mb-10">We source all-natural, certified ingredients that have been revered in Ayurveda for thousands of years.</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Ingredient 1 -->
                <div class="group bg-white border border-[#C49A6C]/15 rounded-[2rem] p-8 text-center transition-all duration-500 hover:shadow-[0_30px_60px_rgba(196,154,108,0.12)] hover:border-[#C49A6C] hover:-translate-y-2 flex flex-col items-center justify-between relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-[#FAF6F0]/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                    
                    <div class="relative z-10 flex flex-col items-center">
                        <!-- Icon Circle Medallion (Large & Double Bordered) -->
                        <div class="w-20 h-20 bg-[#C49A6C]/10 text-[#C49A6C] rounded-full flex items-center justify-center mb-6 border border-[#C49A6C]/30 shadow-xs ring-6 ring-[#C49A6C]/5 group-hover:bg-[#C49A6C] group-hover:text-white group-hover:rotate-[15deg] transition-all duration-500 ease-out">
                            <svg class="w-9 h-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 3.5 2.5 4.5 1 2 1.5 3.5.5 5.5a3 3 0 1 1-6.5-1.5" />
                                <path d="M4 21h16M6 18h12" />
                            </svg>
                        </div>
                        <h3 class="font-serif font-bold text-lg text-gray-900 mb-2 group-hover:text-[#C49A6C] transition-colors duration-300">Desi Cow Dung (Gomaya)</h3>
                        <div class="w-10 h-[1.5px] bg-[#C49A6C]/30 mb-4 group-hover:w-16 transition-all duration-500 rounded-full mx-auto"></div>
                        <p class="text-xs sm:text-sm text-gray-500 font-sans leading-relaxed">Sourced from organic Goshala, it purifies the atmosphere and acts as an organic, charcoal-free base.</p>
                    </div>
                </div>

                <!-- Ingredient 2 -->
                <div class="group bg-white border border-[#C49A6C]/15 rounded-[2rem] p-8 text-center transition-all duration-500 hover:shadow-[0_30px_60px_rgba(196,154,108,0.12)] hover:border-[#C49A6C] hover:-translate-y-2 flex flex-col items-center justify-between relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-[#FAF6F0]/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                    
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-20 h-20 bg-[#C49A6C]/10 text-[#C49A6C] rounded-full flex items-center justify-center mb-6 border border-[#C49A6C]/30 shadow-xs ring-6 ring-[#C49A6C]/5 group-hover:bg-[#C49A6C] group-hover:text-white group-hover:rotate-[15deg] transition-all duration-500 ease-out">
                            <svg class="w-9 h-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 10a7 7 0 0 0 14 0H5z" fill="currentColor" fill-opacity="0.05" />
                                <path d="M19 10v4a3 3 0 0 1-3 3H8a3 3 0 0 1-3-3v-4" />
                                <path d="M12 5l-3 5M16 3l-4 7" stroke-width="2" />
                            </svg>
                        </div>
                        <h3 class="font-serif font-bold text-lg text-gray-900 mb-2 group-hover:text-[#C49A6C] transition-colors duration-300">Pure Herbs & Resins</h3>
                        <div class="w-10 h-[1.5px] bg-[#C49A6C]/30 mb-4 group-hover:w-16 transition-all duration-500 rounded-full mx-auto"></div>
                        <p class="text-xs sm:text-sm text-gray-500 font-sans leading-relaxed">Guggul, Loban, Jatamansi and other sacred herbs that eliminate negative energy and soothe the mind.</p>
                    </div>
                </div>

                <!-- Ingredient 3 -->
                <div class="group bg-white border border-[#C49A6C]/15 rounded-[2rem] p-8 text-center transition-all duration-500 hover:shadow-[0_30px_60px_rgba(196,154,108,0.12)] hover:border-[#C49A6C] hover:-translate-y-2 flex flex-col items-center justify-between relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-[#FAF6F0]/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                    
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-20 h-20 bg-[#C49A6C]/10 text-[#C49A6C] rounded-full flex items-center justify-center mb-6 border border-[#C49A6C]/30 shadow-xs ring-6 ring-[#C49A6C]/5 group-hover:bg-[#C49A6C] group-hover:text-white group-hover:rotate-[15deg] transition-all duration-500 ease-out">
                            <svg class="w-9 h-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22a7 7 0 0 0 7-7c0-4.3-7-13-7-13S5 10.7 5 15a7 7 0 0 0 7 7z" fill="currentColor" fill-opacity="0.05" />
                                <path d="M12 18a3 3 0 0 0 3-3c0-2-3-5-3-5s-3 3-3 5a3 3 0 0 0 3 3z" />
                            </svg>
                        </div>
                        <h3 class="font-serif font-bold text-lg text-gray-900 mb-2 group-hover:text-[#C49A6C] transition-colors duration-300">Natural Essential Oils</h3>
                        <div class="w-10 h-[1.5px] bg-[#C49A6C]/30 mb-4 group-hover:w-16 transition-all duration-500 rounded-full mx-auto"></div>
                        <p class="text-xs sm:text-sm text-gray-500 font-sans leading-relaxed">Premium extracts of Rose, Sandalwood, Lavender and Jasmine that linger for hours chemical-free.</p>
                    </div>
                </div>

                <!-- Ingredient 4 -->
                <div class="group bg-white border border-[#C49A6C]/15 rounded-[2rem] p-8 text-center transition-all duration-500 hover:shadow-[0_30px_60px_rgba(196,154,108,0.12)] hover:border-[#C49A6C] hover:-translate-y-2 flex flex-col items-center justify-between relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-[#FAF6F0]/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                    
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-20 h-20 bg-[#C49A6C]/10 text-[#C49A6C] rounded-full flex items-center justify-center mb-6 border border-[#C49A6C]/30 shadow-xs ring-6 ring-[#C49A6C]/5 group-hover:bg-[#C49A6C] group-hover:text-white group-hover:rotate-[15deg] transition-all duration-500 ease-out">
                            <svg class="w-9 h-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 3a6 6 0 0 0-6 6v3a4 4 0 0 0 4 4h4a4 4 0 0 0 4-4V9a6 6 0 0 0-6-6z" fill="currentColor" fill-opacity="0.05" />
                                <path d="M8 8h8M7 12h10M10 16h4M12 3v3" />
                            </svg>
                        </div>
                        <h3 class="font-serif font-bold text-lg text-gray-900 mb-2 group-hover:text-[#C49A6C] transition-colors duration-300">Ghee & Honey</h3>
                        <div class="w-10 h-[1.5px] bg-[#C49A6C]/30 mb-4 group-hover:w-16 transition-all duration-500 rounded-full mx-auto"></div>
                        <p class="text-xs sm:text-sm text-gray-500 font-sans leading-relaxed">Combined as natural binders, creating a slow-burning incense stick that emits positive spiritual frequencies.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- Testimonials -->
    <div class="bg-[#FAF6F0]/30 pt-8 pb-10 border-t border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-10">
                <span class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest bg-[#C49A6C]/10 px-3.5 py-1.5 rounded-full font-serif">Wall of Love</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900 mt-4">Trusted by Devotees</h2>
                <div class="w-16 h-1 bg-[#C49A6C] mx-auto mt-4 mb-3 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @if($testimonials->isEmpty())
                    <!-- Testimonial 1 -->
                    <div class="bg-white p-8 rounded-3xl shadow-[0_10px_30px_rgba(196,154,108,0.03)] border border-[#C49A6C]/15 text-center relative hover:shadow-[0_20px_50px_rgba(196,154,108,0.12)] hover:border-[#C49A6C] hover:-translate-y-1 transition-all duration-300">
                        <span class="absolute -top-6 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-[#C49A6C] to-[#b0875b] text-white w-12 h-12 rounded-full flex items-center justify-center text-2xl shadow-lg font-serif border-2 border-white ring-4 ring-[#C49A6C]/10">“</span>
                        <div class="text-[#C49A6C] text-sm mb-4 mt-4 flex justify-center gap-1">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        </div>
                        <p class="text-gray-600 italic mb-4 text-sm leading-relaxed">
                            "I ordered the Vedic Sandal Dhoop. The aroma is incredibly authentic and lingering. Unlike ordinary incense, there's absolutely no chemical smell or throat irritation."
                        </p>
                        <div class="w-8 h-[1px] bg-[#C49A6C]/30 mx-auto my-3"></div>
                        <h4 class="font-bold font-serif text-gray-955 tracking-wider text-base">RAHUL SHARMA</h4>
                        <p class="text-[10px] text-[#C49A6C] uppercase tracking-widest font-bold mt-1">Delhi</p>
                    </div>
                    <!-- Testimonial 2 -->
                    <div class="bg-white p-8 rounded-3xl shadow-[0_10px_30px_rgba(196,154,108,0.03)] border border-[#C49A6C]/15 text-center relative hover:shadow-[0_20px_50px_rgba(196,154,108,0.12)] hover:border-[#C49A6C] hover:-translate-y-1 transition-all duration-300">
                        <span class="absolute -top-6 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-[#C49A6C] to-[#b0875b] text-white w-12 h-12 rounded-full flex items-center justify-center text-2xl shadow-lg font-serif border-2 border-white ring-4 ring-[#C49A6C]/10">“</span>
                        <div class="text-[#C49A6C] text-sm mb-4 mt-4 flex justify-center gap-1">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        </div>
                        <p class="text-gray-600 italic mb-4 text-sm leading-relaxed">
                            "Vedic Botanica's Gomaya dhoop sticks smell pure and sacred, exactly like a temple hawan. My daily meditation feels much more focused now."
                        </p>
                        <div class="w-8 h-[1px] bg-[#C49A6C]/30 mx-auto my-3"></div>
                        <h4 class="font-bold font-serif text-gray-955 tracking-wider text-base">PRIYA MISHRA</h4>
                        <p class="text-[10px] text-[#C49A6C] uppercase tracking-widest font-bold mt-1">Mumbai</p>
                    </div>
                    <!-- Testimonial 3 -->
                    <div class="bg-white p-8 rounded-3xl shadow-[0_10px_30px_rgba(196,154,108,0.03)] border border-[#C49A6C]/15 text-center relative hover:shadow-[0_20px_50px_rgba(196,154,108,0.12)] hover:border-[#C49A6C] hover:-translate-y-1 transition-all duration-300">
                        <span class="absolute -top-6 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-[#C49A6C] to-[#b0875b] text-white w-12 h-12 rounded-full flex items-center justify-center text-2xl shadow-lg font-serif border-2 border-white ring-4 ring-[#C49A6C]/10">“</span>
                        <div class="text-[#C49A6C] text-sm mb-4 mt-4 flex justify-center gap-1">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        </div>
                        <p class="text-gray-600 italic mb-4 text-sm leading-relaxed">
                            "The packaging is beautiful and premium, making it a perfect gift. Very fast delivery and excellent customer support from Vedic Botanica."
                        </p>
                        <div class="w-8 h-[1px] bg-[#C49A6C]/30 mx-auto my-3"></div>
                        <h4 class="font-bold font-serif text-gray-955 tracking-wider text-base">ANKIT VERMA</h4>
                        <p class="text-[10px] text-[#C49A6C] uppercase tracking-widest font-bold mt-1">Bengaluru</p>
                    </div>
                @else
                    @foreach($testimonials as $testimonial)
                    <div class="bg-white p-8 rounded-3xl shadow-[0_10px_30px_rgba(196,154,108,0.03)] border border-[#C49A6C]/15 text-center relative hover:shadow-[0_20px_50px_rgba(196,154,108,0.12)] hover:border-[#C49A6C] hover:-translate-y-1 transition-all duration-300">
                        <span class="absolute -top-6 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-[#C49A6C] to-[#b0875b] text-white w-12 h-12 rounded-full flex items-center justify-center text-2xl shadow-lg font-serif border-2 border-white ring-4 ring-[#C49A6C]/10">“</span>
                        <div class="text-[#C49A6C] text-sm mb-4 mt-4 flex justify-center gap-1">
                            @for($i = 0; $i < ($testimonial->rating ?? 5); $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        <p class="text-gray-600 italic mb-4 text-sm leading-relaxed">
                            "{{ $testimonial->content }}"
                        </p>
                        <div class="w-8 h-[1px] bg-[#C49A6C]/30 mx-auto my-3"></div>
                        <h4 class="font-bold font-serif text-gray-955 tracking-wider text-base uppercase">{{ $testimonial->name }}</h4>
                        @if($testimonial->location)
                            <p class="text-[10px] text-[#C49A6C] uppercase tracking-widest font-bold mt-1">{{ $testimonial->location }}</p>
                        @endif
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timerContainer = document.getElementById('deal-countdown');
            if (!timerContainer) return;

            const endTimeStr = timerContainer.getAttribute('data-end-time');
            const endTime = new Date(endTimeStr).getTime();

            const daysEl = document.getElementById('cd-days');
            const hoursEl = document.getElementById('cd-hours');
            const minsEl = document.getElementById('cd-minutes');
            const secsEl = document.getElementById('cd-seconds');

            function updateTimer() {
                const now = new Date().getTime();
                const difference = endTime - now;

                if (difference <= 0) {
                    clearInterval(interval);
                    timerContainer.innerHTML = '<span class="text-sm font-bold text-red-500">Deal Expired!</span>';
                    return;
                }

                const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
                if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
                if (minsEl) minsEl.textContent = String(minutes).padStart(2, '0');
                if (secsEl) secsEl.textContent = String(seconds).padStart(2, '0');
            }

            updateTimer();
            const interval = setInterval(updateTimer, 1000);
        });
    </script>
    @endpush
@endsection
