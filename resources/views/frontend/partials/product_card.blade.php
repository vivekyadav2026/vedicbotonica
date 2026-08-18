@php
    $inWishlist = in_array($product->id, session()->get('wishlist', []));
    $images = json_decode($product->images);
    $image = ($images && count($images) > 0) ? asset($images[0]) : asset('images/premium_dhoop_product.png');
@endphp
<div :class="viewMode === 'grid' ? 'flex flex-col h-full p-3 sm:p-4 rounded-2xl border border-[#C49A6C]/20 bg-white hover:shadow-[0_15px_40px_rgba(196,154,108,0.18)] hover:-translate-y-1' : 'flex flex-col sm:flex-row gap-6 items-center sm:items-start p-4 rounded-3xl border border-[#C49A6C]/20 bg-white hover:shadow-xl'" class="group relative transition-all duration-300 w-full">
    <div :class="viewMode === 'grid' ? 'w-full' : 'w-full sm:w-48 sm:h-48 flex-shrink-0'" class="bg-[#FAF6F0]/40 rounded-xl flex items-center justify-center relative overflow-hidden aspect-square border border-gray-50">
        <!-- Product Image -->
        <a href="/product/{{ $product->slug }}" class="w-full h-full flex items-center justify-center">
            <img src="{{ $image }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-105">
        </a>
        
        <!-- Sale Badge -->
        @if($product->sale_price)
            @php
                $discountPercent = round((($product->price - $product->sale_price) / $product->price) * 100);
            @endphp
            <div class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-red-500 text-white text-[9px] uppercase font-bold px-2 py-0.5 rounded-md shadow z-10 tracking-wider font-sans">{{ $discountPercent }}% OFF</div>
        @endif
        
        <!-- Floating Quick Action Icons (Grid Mode Only) -->
        <div :class="viewMode === 'grid' ? 'opacity-100 md:opacity-0 md:group-hover:opacity-100 transform translate-x-0 md:translate-x-4 md:group-hover:translate-x-0' : 'hidden'" class="absolute top-2 right-2 flex flex-col gap-1.5 transition-all duration-300 z-10">
            <button class="bg-white/90 backdrop-blur-xs {{ $inWishlist ? 'text-red-500' : 'text-gray-800' }} hover:text-red-500 hover:bg-white p-2 rounded-full shadow-md border border-gray-150/40 transition w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-xs btn-wishlist cursor-pointer" data-product-id="{{ $product->id }}" title="Add to Wishlist">
                <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
            </button>
            <button class="bg-white/90 backdrop-blur-xs text-gray-800 hover:text-[#C49A6C] hover:bg-white p-2 rounded-full shadow-md border border-gray-150/40 transition w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-xs btn-quickview cursor-pointer" data-product-slug="{{ $product->slug }}" title="Quick View">
                <i class="fa-regular fa-eye"></i>
            </button>
        </div>
        
        <!-- Add to Cart Overlay (Desktop Grid Only) -->
        <div :class="viewMode === 'grid' ? 'translate-y-full group-hover:translate-y-0' : 'hidden'" class="absolute bottom-0 left-0 right-0 transition-transform duration-300 z-10 hidden md:block">
            <button class="w-full bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold py-3.5 tracking-wider text-xs uppercase btn-add-to-cart transition-colors duration-300 cursor-pointer shadow-lg" data-product-id="{{ $product->id }}">
                <i class="fa-solid fa-cart-plus mr-1.5"></i> Add To Cart
            </button>
        </div>
    </div>
    
    <div :class="viewMode === 'grid' ? 'pt-3 sm:pt-4' : 'pt-4 sm:pt-0 sm:pl-6 flex-1 flex flex-col justify-between h-full'" class="text-left flex flex-col">
        <div>
            <h3 :class="viewMode === 'grid' ? 'text-xs sm:text-sm font-sans font-semibold text-gray-800 line-clamp-1' : 'text-xl font-serif font-bold text-gray-900'" class="leading-snug hover:text-[#C49A6C] transition-colors">
                <a href="/product/{{ $product->slug }}">
                    {{ $product->name }}
                </a>
            </h3>
            @if($product->reviews_count > 0)
                <div class="flex items-center space-x-1 mt-1 text-yellow-500 text-[9px] sm:text-[10px]">
                    <div class="flex gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-{{ $i <= round($product->average_rating) ? 'solid' : 'regular' }} fa-star"></i>
                        @endfor
                    </div>
                    <span class="text-gray-400 font-semibold font-sans">({{ $product->reviews_count }})</span>
                </div>
            @endif
            <p :class="viewMode === 'grid' ? 'text-[10px] sm:text-[11px] text-gray-400 line-clamp-1 mt-1' : 'text-sm text-gray-500 mt-2'" class="font-sans font-normal leading-normal">
                {{ $product->short_description }}
            </p>
        </div>
        
        <div :class="viewMode === 'grid' ? 'mt-3 border-t border-gray-50 pt-2 flex items-center justify-between' : 'mt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-t border-gray-50 pt-4'">
            <div>
                @if($product->sale_price)
                @php
                    $discountPercent = round((($product->price - $product->sale_price) / $product->price) * 100);
                @endphp
                <div class="flex items-baseline space-x-1.5 flex-wrap">
                    <span :class="viewMode === 'grid' ? 'text-sm sm:text-base font-bold' : 'text-2xl font-bold'" class="text-gray-900">₹{{ number_format($product->sale_price) }}</span>
                    <span :class="viewMode === 'grid' ? 'text-[10px] sm:text-xs' : 'text-sm'" class="text-gray-400 line-through">₹{{ number_format($product->price) }}</span>
                    <span class="text-[10px] text-red-500 font-bold font-sans hidden sm:inline">({{ $discountPercent }}% Off)</span>
                </div>
                @else
                <span :class="viewMode === 'grid' ? 'text-sm sm:text-base font-bold' : 'text-2xl font-bold'" class="text-gray-900">₹{{ number_format($product->price) }}</span>
                @endif
            </div>
            
            <!-- Mobile Grid / Default Cart Icon Button -->
            <button x-show="viewMode === 'grid'" class="md:hidden bg-[#C49A6C]/10 hover:bg-[#C49A6C] text-[#C49A6C] hover:text-white p-2 rounded-lg transition-colors duration-300 w-8 h-8 flex items-center justify-center btn-add-to-cart cursor-pointer" data-product-id="{{ $product->id }}" title="Add to Cart">
                <i class="fa-solid fa-cart-plus text-xs"></i>
            </button>

            <!-- List View Action Panel -->
            <div x-show="viewMode === 'list'" class="flex items-center space-x-3 mt-3 sm:mt-0">
                <button class="bg-[#C49A6C] hover:bg-[#b0875b] text-white px-5 py-2.5 rounded-lg font-semibold tracking-wider text-xs uppercase btn-add-to-cart transition-colors duration-300 shadow-sm cursor-pointer" data-product-id="{{ $product->id }}">
                    ADD TO CART
                </button>
                <button class="bg-white {{ $inWishlist ? 'text-red-500' : 'text-gray-800' }} hover:text-red-500 p-2.5 rounded-lg border border-gray-200 hover:bg-gray-50 transition w-10 h-10 flex items-center justify-center text-sm btn-wishlist cursor-pointer" data-product-id="{{ $product->id }}">
                    <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                </button>
                <button class="bg-white text-gray-800 hover:text-[#C49A6C] p-2.5 rounded-lg border border-gray-200 hover:bg-gray-50 transition w-10 h-10 flex items-center justify-center text-sm btn-quickview cursor-pointer" data-product-slug="{{ $product->slug }}">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>
        </div>
    </div>
</div>
