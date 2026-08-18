@extends('layouts.frontend')

@section('title', 'Product Detail')

@section('content')
    <!-- Product Detail Section -->
    @php
        $images = json_decode($product->images);
        $fallbackImage = asset('images/premium_dhoop_product.png');
        $image = ($images && count($images) > 0) ? asset($images[0]) : $fallbackImage;
    @endphp
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <!-- Breadcrumbs left-aligned -->
        <p class="text-[10px] md:text-xs text-gray-500 uppercase tracking-widest leading-relaxed font-sans mb-8">
            <a href="/" class="hover:text-[#C49A6C] transition-colors duration-300">Home</a> <span class="mx-1.5 text-gray-300">/</span> 
            <a href="/shop" class="hover:text-[#C49A6C] transition-colors duration-300">Shop</a> <span class="mx-1.5 text-gray-300">/</span> 
            <a href="/shop?categories[]={{ $product->category_id }}" class="hover:text-[#C49A6C] transition-colors duration-300">{{ $product->category->name }}</a> <span class="mx-1.5 text-gray-300">/</span> 
            <span class="text-gray-900 font-medium font-serif">{{ $product->name }}</span>
        </p>

        <div class="lg:grid lg:grid-cols-12 lg:gap-x-8 xl:gap-x-12 items-start">
            
            <!-- Left: Image Gallery (Span 7) -->
            <div class="lg:col-span-7 mb-10 lg:mb-0" x-data="{ activeImage: '{{ $image }}' }">
                <div class="flex flex-col-reverse md:flex-row gap-4">
                    <!-- Thumbnails Carousel (Vertical on MD+, Horizontal on Mobile) -->
                    @if($images && count($images) > 1)
                        <div class="flex flex-row md:flex-col gap-3 overflow-x-auto md:overflow-x-visible md:overflow-y-auto max-h-[500px] flex-shrink-0 pb-2 md:pb-0">
                            @foreach($images as $img)
                                @php $imgUrl = asset($img); @endphp
                                <button type="button" @click="activeImage = '{{ $imgUrl }}'" 
                                        :class="activeImage === '{{ $imgUrl }}' ? 'border-[#C49A6C] ring-2 ring-[#C49A6C]/30 shadow-md' : 'border-gray-200 hover:border-[#C49A6C]/30'"
                                        class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-2xl border p-2 overflow-hidden transition-all duration-300 flex items-center justify-center focus:outline-none flex-shrink-0 cursor-pointer shadow-xs">
                                    <img src="{{ $imgUrl }}" alt="Product Thumbnail" class="max-h-full max-w-full object-contain">
                                </button>
                            @endforeach
                        </div>
                    @endif
                    
                    <!-- Main Image Card -->
                    <div class="md:flex-grow bg-white rounded-3xl overflow-hidden border border-[#C49A6C]/10 shadow-[0_10px_35px_rgba(196,154,108,0.05)] flex items-center justify-center p-0 aspect-square group max-w-md md:max-w-none mx-auto w-full">
                        <img :src="activeImage" alt="{{ $product->name }}" class="w-full h-full object-contain block transition-transform duration-700 ease-out group-hover:scale-103">
                    </div>
                </div>
            </div>

            <!-- Right: Product Details Stack (Span 5) -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Title & Category -->
                <div class="relative">
                    <span class="text-[10px] text-[#C49A6C] uppercase font-bold tracking-widest block font-serif mb-1">{{ $product->category->name ?? 'Sacred Collection' }}</span>
                    <div class="flex justify-between items-start gap-4">
                        <h1 class="text-2xl sm:text-3xl font-serif font-bold text-gray-900 leading-tight">{{ $product->name }}</h1>
                        <button type="button" id="share-btn" data-title="{{ $product->name }}" data-url="{{ request()->url() }}" class="text-gray-400 hover:text-[#C49A6C] transition-colors p-2 rounded-full hover:bg-[#FAF6F0]/50 cursor-pointer" title="Share Product">
                            <i class="fa-solid fa-share-nodes text-lg"></i>
                        </button>
                    </div>
                    @if($product->reviews_count > 0)
                    <div class="flex items-center space-x-2 mt-2">
                        <div class="flex text-yellow-500 text-[10px] gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= round($product->average_rating) ? 'solid' : 'regular' }} fa-star"></i>
                            @endfor
                        </div>
                        <a href="#reviews-section" class="text-xs font-bold text-[#C49A6C] hover:underline font-sans">
                            {{ $product->average_rating }} ({{ $product->reviews_count }} {{ Str::plural('review', $product->reviews_count) }})
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Price Area -->
                <div class="flex items-baseline space-x-3">
                    @if($product->sale_price)
                        <span class="text-3xl font-serif font-extrabold text-gray-950">₹{{ number_format($product->sale_price) }}</span>
                        <span class="text-lg text-gray-400 line-through font-serif">₹{{ number_format($product->price) }}</span>
                        @php
                            $pctDiscount = round((($product->price - $product->sale_price) / $product->price) * 100);
                        @endphp
                        <span class="text-red-500 text-xs font-bold font-sans uppercase tracking-wider">{{ $pctDiscount }}% Off</span>
                    @else
                        <span class="text-3xl font-serif font-extrabold text-gray-950">₹{{ number_format($product->price) }}</span>
                    @endif
                </div>

                <!-- Size / Weight Selection -->
                <div class="space-y-2">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Size / Weight</span>
                    <div class="flex gap-2">
                        <button type="button" class="border-black bg-black text-white px-5 py-2.5 rounded-xl text-xs font-semibold font-sans tracking-wide shadow-xs border">
                            {{ $product->weight * 1000 }}g Standard
                        </button>
                    </div>
                </div>

                <!-- Form & Actions -->
                <form class="space-y-3" id="product-detail-form">
                    @csrf
                    @if($product->quantity <= 0)
                        <!-- Out of stock display -->
                        <button type="button" disabled class="w-full bg-gray-100 border border-gray-200 text-gray-400 font-serif font-bold h-12 rounded-xl tracking-wider text-xs uppercase cursor-not-allowed flex items-center justify-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <span>Temporarily Out of Stock</span>
                        </button>
                    @else
                        <div class="flex gap-3">
                            <!-- Qty Selector -->
                            <div class="flex items-center border border-gray-250 rounded-xl bg-white overflow-hidden shadow-xs h-12 w-32 justify-between flex-shrink-0">
                                <button type="button" id="qty-minus" class="w-10 h-full text-gray-600 hover:bg-[#FAF6F0] hover:text-[#C49A6C] transition-all duration-300 focus:outline-none cursor-pointer"><i class="fa-solid fa-minus text-xs"></i></button>
                                <input type="number" id="qty-input" name="quantity" class="w-12 h-full text-center border-none focus:ring-0 text-sm font-semibold text-gray-955 focus:outline-none bg-transparent" value="1" min="1" max="{{ $product->quantity }}">
                                <button type="button" id="qty-plus" class="w-10 h-full text-gray-600 hover:bg-[#FAF6F0] hover:text-[#C49A6C] transition-all duration-300 focus:outline-none cursor-pointer"><i class="fa-solid fa-plus text-xs"></i></button>
                            </div>
                            
                            <!-- Add to Bag -->
                            <button type="button" id="detail-add-to-cart" data-product-id="{{ $product->id }}" class="flex-grow bg-white border border-black hover:bg-gray-50 text-gray-900 font-serif font-bold h-12 rounded-xl transition-all duration-300 tracking-wider text-xs uppercase cursor-pointer active:scale-97 flex items-center justify-center gap-2">
                                Add to bag
                            </button>
                        </div>
                        
                        <!-- Buy Now -->
                        <button type="button" id="detail-buy-now" data-product-id="{{ $product->id }}" class="w-full bg-black hover:bg-gray-950 text-white font-serif font-bold h-12 rounded-xl transition-all duration-300 tracking-wider text-xs uppercase cursor-pointer shadow-md active:scale-97 flex items-center justify-center gap-2">
                            Buy Now
                        </button>
                    @endif
                </form>

                @if($product->is_combo)
                    <!-- What's Inside This Combo? Section -->
                    <div class="border border-[#C49A6C]/25 bg-[#FAF6F0]/30 rounded-2xl p-5 sm:p-6 space-y-4 shadow-sm">
                        <div class="flex items-center justify-between pb-3 border-b border-[#C49A6C]/15">
                            <h3 class="font-serif font-bold text-gray-900 text-sm uppercase tracking-wider flex items-center gap-2">
                                <i class="fa-solid fa-box-open text-[#C49A6C]"></i>
                                <span>What's Inside This Combo?</span>
                            </h3>
                            <span class="bg-[#C49A6C] text-white text-[9px] uppercase font-bold px-2 py-0.5 rounded-md tracking-wider font-sans">
                                Special Bundle
                            </span>
                        </div>

                        <!-- Included Products List -->
                        <div class="space-y-3">
                            @foreach($product->comboItems as $item)
                                @if($item->product)
                                    @php
                                        $childImages = json_decode($item->product->images);
                                        $childImg = ($childImages && count($childImages) > 0) ? asset($childImages[0]) : asset('images/premium_dhoop_product.png');
                                        $childPrice = $item->product->sale_price ?: $item->product->price;
                                    @endphp
                                    <div class="flex items-center justify-between bg-white/70 p-3 rounded-xl border border-gray-100 gap-3">
                                        <div class="flex items-center space-x-3 min-w-0 flex-1">
                                            <img src="{{ $childImg }}" alt="{{ $item->product->name }}" class="w-10 h-10 object-contain border rounded-lg p-0.5 bg-[#FAF6F0]/30 flex-shrink-0">
                                            <div class="min-w-0">
                                                <a href="/product/{{ $item->product->slug }}" class="text-xs sm:text-sm font-semibold text-gray-800 hover:text-[#C49A6C] transition truncate block">{{ $item->product->name }}</a>
                                                <span class="text-[10px] text-gray-400 font-medium font-sans">Value: ₹{{ number_format($childPrice, 2) }} each</span>
                                            </div>
                                        </div>
                                        <div class="text-xs font-bold text-[#C49A6C] whitespace-nowrap bg-[#FAF6F0] border border-[#C49A6C]/10 px-2.5 py-1 rounded-lg font-sans">
                                            × {{ $item->quantity }}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Pricing Summary math -->
                        <div class="pt-3 border-t border-[#C49A6C]/15 space-y-2 text-xs font-sans">
                            <div class="flex justify-between text-gray-500 font-medium">
                                <span>Individual Product Total:</span>
                                <span>₹{{ number_format($product->individual_value, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-900 font-bold">
                                <span>Combo Selling Price:</span>
                                <span>₹{{ number_format($product->sale_price ?: $product->price, 2) }}</span>
                            </div>
                            @if($product->savings > 0)
                                <div class="flex justify-between text-emerald-700 font-bold bg-emerald-50 border border-emerald-100/55 p-2 rounded-xl text-center">
                                    <span>You Save:</span>
                                    <span>₹{{ number_format($product->savings, 2) }} ({{ $product->discount_percent }}% OFF)</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Product Info Table -->
                <div class="border border-gray-150 rounded-2xl overflow-hidden bg-white shadow-xs">
                    <div class="bg-gray-50/50 px-4 py-3 border-b border-gray-150">
                        <h3 class="font-serif font-bold text-gray-900 text-xs tracking-wide uppercase">Product Information</h3>
                    </div>
                    <table class="w-full text-left text-xs border-collapse font-sans">
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="px-4 py-2.5 font-bold text-gray-400 w-1/3">Brand</td>
                                <td class="px-4 py-2.5 font-semibold text-gray-800">Vedic Botanica</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2.5 font-bold text-gray-400">Category</td>
                                <td class="px-4 py-2.5 font-semibold text-[#C49A6C] hover:underline">
                                    <a href="/shop?categories[]={{ $product->category_id }}">{{ $product->category->name }}</a>
                                </td>
                            </tr>
                            @if($product->sku)
                            <tr>
                                <td class="px-4 py-2.5 font-bold text-gray-400">SKU</td>
                                <td class="px-4 py-2.5 font-semibold text-gray-800">{{ $product->sku }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="px-4 py-2.5 font-bold text-gray-400">Packed Weight</td>
                                <td class="px-4 py-2.5 font-semibold text-gray-800">{{ $product->weight * 1000 }}g ({{ $product->weight }} kg)</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2.5 font-bold text-gray-400">Box Dimensions</td>
                                <td class="px-4 py-2.5 font-semibold text-gray-800">{{ $product->length }} x {{ $product->width }} x {{ $product->height }} cm</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2.5 font-bold text-gray-400">Product Type</td>
                                <td class="px-4 py-2.5 font-semibold text-gray-800">Ayurvedic Wellness</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2.5 font-bold text-gray-400">Origin</td>
                                <td class="px-4 py-2.5 font-semibold text-gray-800">India</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Product Description with read more toggle -->
                <div class="space-y-3" x-data="{ expanded: false }">
                    <h3 class="font-serif font-bold text-gray-900 text-sm border-b border-gray-100 pb-2">Product Description</h3>
                    <div :class="expanded ? '' : 'max-h-56 overflow-hidden relative'" class="transition-all duration-300">
                        @if($product->short_description)
                            <p class="font-medium text-gray-800 mb-3 font-serif text-sm">{{ $product->short_description }}</p>
                        @endif
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-sans whitespace-pre-line">{{ $product->description }}</p>
                        <div x-show="!expanded" class="absolute bottom-0 left-0 right-0 h-10 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
                    </div>
                    <button @click="expanded = !expanded" class="text-[10px] font-bold text-[#C49A6C] uppercase tracking-wider focus:outline-none hover:underline cursor-pointer">
                        <span x-text="expanded ? 'Read Less' : 'Read More'"></span>
                    </button>
                </div>

            </div>
        </div>



        <!-- Product Reviews Section -->
        <div id="reviews-section" class="mt-20 border-t border-gray-150/70 pt-16">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-2xl sm:text-3xl font-serif font-bold text-center text-gray-900 mb-2">Customer Reviews</h2>
                <p class="text-xs sm:text-sm text-gray-500 text-center mb-10 font-sans tracking-wide">Read what our customers are saying about {{ $product->name }}</p>

                @if($product->reviews_count > 0)
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-12 items-start">
                        
                        <!-- Left: Reviews Summary Card (Span 4) -->
                        <div class="md:col-span-4 bg-[#FAF6F0]/30 rounded-3xl border border-[#C49A6C]/10 p-6 text-center shadow-xs">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 font-sans">Average Rating</h3>
                            <div class="text-5xl font-serif font-black text-gray-950 mb-2">
                                {{ $product->average_rating }}
                            </div>
                            <div class="flex justify-center text-yellow-500 text-sm gap-1 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-{{ $i <= round($product->average_rating) ? 'solid' : 'regular' }} fa-star"></i>
                                @endfor
                            </div>
                            <p class="text-xs text-gray-500 font-sans font-medium mb-6">Based on {{ $product->reviews_count }} {{ Str::plural('Review', $product->reviews_count) }}</p>

                            <!-- Rating Distribution Bars -->
                            <div class="space-y-2 text-left">
                                @php
                                    $distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                                    foreach($product->activeReviews as $rev) {
                                        if(isset($distribution[$rev->rating])) {
                                            $distribution[$rev->rating]++;
                                        }
                                    }
                                    $totalReviews = $product->reviews_count ?: 1;
                                @endphp
                                @foreach([5, 4, 3, 2, 1] as $stars)
                                    @php
                                        $count = $distribution[$stars];
                                        $pct = ($count / $totalReviews) * 100;
                                    @endphp
                                    <div class="flex items-center text-xs">
                                        <span class="w-10 text-gray-500 font-medium font-sans flex items-center justify-end mr-2">
                                            {{ $stars }} <i class="fa-solid fa-star text-yellow-500 text-[10px] ml-1"></i>
                                        </span>
                                        <div class="flex-grow h-2 bg-gray-100 rounded-full overflow-hidden mr-3">
                                            <div class="h-full bg-[#C49A6C] rounded-full" style="width: {{ $pct }}%"></div>
                                        </div>
                                        <span class="w-6 text-gray-400 text-right font-semibold font-sans">{{ $count }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Right: Reviews List (Span 8) -->
                        <div class="md:col-span-8 space-y-4 max-h-[600px] overflow-y-auto pr-2">
                            @foreach($product->activeReviews as $rev)
                                <div class="border border-gray-150 rounded-2xl p-5 bg-white shadow-xs hover:border-[#C49A6C]/30 transition duration-300">
                                    <div class="flex justify-between items-start gap-4 mb-2 flex-wrap sm:flex-nowrap">
                                        <div>
                                            <span class="block font-serif font-bold text-gray-900 text-sm leading-snug">{{ $rev->reviewer_name }}</span>
                                            <div class="flex text-yellow-500 text-[9px] gap-0.5 mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa-{{ $i <= $rev->rating ? 'solid' : 'regular' }} fa-star"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <span class="text-[10px] text-gray-400 font-sans tracking-wide">{{ $rev->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <p class="text-xs sm:text-sm text-gray-650 leading-relaxed font-sans mt-3 italic">
                                        "{{ $rev->review }}"
                                    </p>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-[#FAF6F0]/20 border border-dashed border-[#C49A6C]/25 rounded-3xl p-10 text-center max-w-md mx-auto shadow-xs">
                        <div class="bg-white/80 h-12 w-12 rounded-full border border-[#C49A6C]/10 flex items-center justify-center mx-auto mb-4 text-[#C49A6C] shadow-sm">
                            <i class="fa-solid fa-star-half-stroke text-lg"></i>
                        </div>
                        <h3 class="font-serif font-bold text-gray-900 text-sm mb-1">No Reviews Yet</h3>
                        <p class="text-xs text-gray-500 font-sans leading-relaxed">There are no reviews for this product yet. Share your experience with Vedic Botanica products once you receive your order!</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product FAQ Section -->
        <div class="mt-20 border-t border-gray-150/70 pt-16" x-data="{ activeFaq: null }">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-2xl sm:text-3xl font-serif font-bold text-center text-gray-900 mb-2">Frequently Asked Questions</h2>
                <p class="text-xs sm:text-sm text-gray-500 text-center mb-10 font-sans tracking-wide">Got questions about our natural Vedic formulations? Here are some answers.</p>
                
                <div class="space-y-4">
                    <!-- FAQ 1 -->
                    <div class="border border-gray-150 rounded-2xl bg-[#FAF6F0]/20 overflow-hidden transition-all duration-300">
                        <button @click="activeFaq === 1 ? activeFaq = null : activeFaq = 1" 
                                class="w-full flex justify-between items-center py-4.5 px-5 sm:px-6 text-left focus:outline-none cursor-pointer">
                            <span class="text-sm font-serif font-bold text-gray-900">Is this product natural and safe to use daily?</span>
                            <span class="text-[#C49A6C] transition-transform duration-300" :class="activeFaq === 1 ? 'rotate-180' : ''">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </span>
                        </button>
                        <div x-show="activeFaq === 1" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="pb-5 px-5 sm:px-6 text-xs sm:text-sm text-gray-650 leading-relaxed font-sans border-t border-gray-100/50 pt-3">
                            Yes, absolutely. Our products are formulated using natural, pure cow dung base mixed with organic herbs, natural resins, and premium essential oils. They are completely free from charcoal, phthalates, and harmful chemicals, making them safe for daily home use, meditation, and children.
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="border border-gray-150 rounded-2xl bg-[#FAF6F0]/20 overflow-hidden transition-all duration-300">
                        <button @click="activeFaq === 2 ? activeFaq = null : activeFaq = 2" 
                                class="w-full flex justify-between items-center py-4.5 px-5 sm:px-6 text-left focus:outline-none cursor-pointer">
                            <span class="text-sm font-serif font-bold text-gray-900">Does this dhoop stick produce heavy smoke?</span>
                            <span class="text-[#C49A6C] transition-transform duration-300" :class="activeFaq === 2 ? 'rotate-180' : ''">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </span>
                        </button>
                        <div x-show="activeFaq === 2" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="pb-5 px-5 sm:px-6 text-xs sm:text-sm text-gray-650 leading-relaxed font-sans border-t border-gray-100/50 pt-3">
                            No, our dhoop sticks are crafted to produce a slow, steady, and soothing mild smoke that purifies the air without causing suffocation or heavy breathing issues, unlike artificial charcoal-based incense sticks.
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="border border-gray-150 rounded-2xl bg-[#FAF6F0]/20 overflow-hidden transition-all duration-300">
                        <button @click="activeFaq === 3 ? activeFaq = null : activeFaq = 3" 
                                class="w-full flex justify-between items-center py-4.5 px-5 sm:px-6 text-left focus:outline-none cursor-pointer">
                            <span class="text-sm font-serif font-bold text-gray-900">How long does a single dhoop stick burn?</span>
                            <span class="text-[#C49A6C] transition-transform duration-300" :class="activeFaq === 3 ? 'rotate-180' : ''">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </span>
                        </button>
                        <div x-show="activeFaq === 3" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="pb-5 px-5 sm:px-6 text-xs sm:text-sm text-gray-650 leading-relaxed font-sans border-t border-gray-100/50 pt-3">
                            On average, a single premium stick burns for approximately 35 to 45 minutes, leaving behind a subtle, lingering pure botanical fragrance that stays in the room for several hours.
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="border border-gray-150 rounded-2xl bg-[#FAF6F0]/20 overflow-hidden transition-all duration-300">
                        <button @click="activeFaq === 4 ? activeFaq = null : activeFaq = 4" 
                                class="w-full flex justify-between items-center py-4.5 px-5 sm:px-6 text-left focus:outline-none cursor-pointer">
                            <span class="text-sm font-serif font-bold text-gray-900">What are the benefits of using cow dung-based dhoop?</span>
                            <span class="text-[#C49A6C] transition-transform duration-300" :class="activeFaq === 4 ? 'rotate-180' : ''">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </span>
                        </button>
                        <div x-show="activeFaq === 4" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="pb-5 px-5 sm:px-6 text-xs sm:text-sm text-gray-650 leading-relaxed font-sans border-t border-gray-100/50 pt-3">
                            According to Ayurvedic traditions, burning cow dung combined with sacred herbs purifies the atmosphere, destroys airborne pathogens, repels mosquitoes naturally, and creates a positive, stress-relieving ambiance suitable for prayers, yoga, and meditation.
                        </div>
                    </div>

                    <!-- FAQ 5 -->
                    <div class="border border-gray-150 rounded-2xl bg-[#FAF6F0]/20 overflow-hidden transition-all duration-300">
                        <button @click="activeFaq === 5 ? activeFaq = null : activeFaq = 5" 
                                class="w-full flex justify-between items-center py-4.5 px-5 sm:px-6 text-left focus:outline-none cursor-pointer">
                            <span class="text-sm font-serif font-bold text-gray-900">How should I store these dhoop sticks?</span>
                            <span class="text-[#C49A6C] transition-transform duration-300" :class="activeFaq === 5 ? 'rotate-180' : ''">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </span>
                        </button>
                        <div x-show="activeFaq === 5" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="pb-5 px-5 sm:px-6 text-xs sm:text-sm text-gray-650 leading-relaxed font-sans border-t border-gray-100/50 pt-3">
                            To preserve their natural aroma and keep them dry, store the dhoop sticks in a cool, dry place inside their original packaging, away from direct sunlight, humidity, or moisture.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        <div class="mt-24">
            <h2 class="text-3xl font-serif font-bold text-center text-gray-900 mb-12 relative">
                Related Products
                <span class="absolute bottom-[-10px] left-1/2 transform -translate-x-1/2 w-12 h-0.5 bg-[#C49A6C]"></span>
            </h2>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
                @foreach($relatedProducts as $relProduct)
                @php
                    $inWishlist = in_array($relProduct->id, session()->get('wishlist', []));
                    $rImages = json_decode($relProduct->images);
                    $rImage = ($rImages && count($rImages) > 0) ? asset($rImages[0]) : $fallbackImage;
                @endphp
                <div class="group relative bg-white border border-[#C49A6C]/20 rounded-3xl p-3 sm:p-4 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(196,154,108,0.15)] hover:border-[#C49A6C] hover:-translate-y-1.5 flex flex-col h-full overflow-hidden">
                    <!-- Image container -->
                    <div class="relative w-full aspect-square bg-gradient-to-br from-[#FAF6F0]/60 to-white rounded-2xl overflow-hidden flex items-center justify-center border border-gray-100/50">
                        <a href="/product/{{ $relProduct->slug }}" class="w-full h-full flex items-center justify-center">
                            <img src="{{ $rImage }}" alt="{{ $relProduct->name }}" class="max-h-[85%] max-w-[85%] object-contain transition-transform duration-700 ease-out group-hover:scale-108">
                        </a>

                        <!-- Badges -->
                        <div class="absolute top-2.5 left-2.5 flex flex-col gap-1 z-10">
                            @if($relProduct->sale_price)
                                @php
                                    $discountPercent = round((($relProduct->price - $relProduct->sale_price) / $relProduct->price) * 100);
                                @endphp
                                <span class="bg-red-500 border border-white text-white text-[9px] font-bold px-2.5 py-0.5 rounded-full shadow-md uppercase tracking-wider">{{ $discountPercent }}% OFF</span>
                            @endif
                        </div>

                        <!-- Floating Quick Action Buttons -->
                        <div class="absolute top-2.5 right-2.5 flex flex-col gap-1.5 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-all duration-300 transform translate-x-0 md:translate-x-4 md:group-hover:translate-x-0 z-10">
                            <button class="bg-white/80 backdrop-blur-md {{ $inWishlist ? 'text-red-500 border-red-200' : 'text-gray-800 border-[#C49A6C]/20' }} hover:text-white hover:bg-[#C49A6C] p-2 rounded-full shadow-md border transition w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-xs btn-wishlist cursor-pointer" data-product-id="{{ $relProduct->id }}" title="Add to Wishlist">
                                <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                            </button>
                            <button class="bg-white/80 backdrop-blur-md text-gray-800 hover:text-white hover:bg-[#C49A6C] p-2 rounded-full shadow-md border border-[#C49A6C]/20 transition w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-xs btn-quickview cursor-pointer" data-product-slug="{{ $relProduct->slug }}" title="Quick View">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>

                        <!-- Desktop Add to Cart Overlay -->
                        <div class="absolute bottom-0 left-0 right-0 translate-y-full group-hover:translate-y-0 transition-all duration-500 z-10 hidden md:block">
                            <button class="w-full bg-gradient-to-r from-[#C49A6C] to-[#b0875b] hover:from-[#b0875b] hover:to-[#9a734c] text-white font-serif font-medium py-3.5 tracking-wider text-xs uppercase btn-add-to-cart transition-all duration-300 cursor-pointer shadow-lg active:scale-95 flex items-center justify-center gap-2" data-product-id="{{ $relProduct->id }}">
                                <i class="fa-solid fa-cart-plus mr-1"></i> Add To Cart
                            </button>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="pt-3 sm:pt-4 text-left flex-1 flex flex-col justify-between">
                        <div class="space-y-1">
                            <h3 class="text-xs sm:text-sm font-serif font-bold text-gray-900 hover:text-[#C49A6C] transition-colors leading-snug line-clamp-1">
                                <a href="/product/{{ $relProduct->slug }}">
                                    {{ $relProduct->name }}
                                </a>
                            </h3>
                            @if($relProduct->reviews_count > 0)
                                <div class="flex items-center space-x-1 mt-1 text-yellow-500 text-[9px] sm:text-[10px]">
                                    <div class="flex gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-{{ $i <= round($relProduct->average_rating) ? 'solid' : 'regular' }} fa-star"></i>
                                        @endfor
                                    </div>
                                    <span class="text-gray-400 font-semibold font-sans font-medium">({{ $relProduct->reviews_count }})</span>
                                </div>
                            @endif
                            <p class="text-[10px] sm:text-[11px] text-gray-400 line-clamp-1 font-sans font-normal leading-normal">{{ $relProduct->short_description }}</p>
                        </div>

                        <div class="pt-2 flex items-center justify-between border-t border-[#FAF6F0] mt-3">
                            <!-- Price -->
                            <div>
                                @if($relProduct->sale_price)
                                    @php
                                        $discountPercent = round((($relProduct->price - $relProduct->sale_price) / $relProduct->price) * 100);
                                    @endphp
                                    <div class="flex items-baseline space-x-1.5 flex-wrap">
                                        <span class="text-sm sm:text-base font-serif font-bold text-gray-900">₹{{ number_format($relProduct->sale_price) }}</span>
                                        <span class="text-[10px] sm:text-xs text-gray-400 line-through">₹{{ number_format($relProduct->price) }}</span>
                                        <span class="text-[10px] text-red-500 font-bold font-sans">({{ $discountPercent }}% Off)</span>
                                    </div>
                                @else
                                    <span class="text-sm sm:text-base font-serif font-bold text-gray-900">₹{{ number_format($relProduct->price) }}</span>
                                @endif
                            </div>

                            <!-- Mobile Add to Cart Button -->
                            <button class="md:hidden bg-[#C49A6C]/10 border border-[#C49A6C]/20 hover:bg-[#C49A6C] text-[#C49A6C] hover:text-white p-2 rounded-xl transition-all duration-300 w-9 h-9 flex items-center justify-center btn-add-to-cart cursor-pointer active:scale-90" data-product-id="{{ $relProduct->id }}" title="Add to Cart">
                                <i class="fa-solid fa-cart-plus text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Mobile Sticky Purchase Bar (only visible on mobile, hides main bottom nav bar) -->
    <div class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-150/70 shadow-[0_-4px_16px_rgba(0,0,0,0.06)] md:hidden flex items-center justify-between px-4 py-3 pb-safe-bottom">
        <div class="flex items-center space-x-3">
            <div class="flex items-center border border-gray-250 rounded-xl bg-gray-50 overflow-hidden h-11">
                <button type="button" onclick="const qi = document.getElementById('qty-input'); if(qi) { qi.value = Math.max(1, parseInt(qi.value) - 1); document.getElementById('qty-input-sticky').value = qi.value; }" class="w-9 h-full text-gray-600 hover:bg-gray-150 transition-colors focus:outline-none cursor-pointer"><i class="fa-solid fa-minus text-xs"></i></button>
                <input type="number" id="qty-input-sticky" readonly class="w-8 h-full text-center border-none bg-transparent focus:ring-0 text-xs font-semibold text-gray-900 focus:outline-none" value="1">
                <button type="button" onclick="const qi = document.getElementById('qty-input'); if(qi) { const max = parseInt(qi.getAttribute('max')) || Infinity; if(parseInt(qi.value) < max) { qi.value = parseInt(qi.value) + 1; } document.getElementById('qty-input-sticky').value = qi.value; }" class="w-9 h-full text-gray-600 hover:bg-gray-150 transition-colors focus:outline-none cursor-pointer"><i class="fa-solid fa-plus text-xs"></i></button>
            </div>
        </div>
        <div class="flex-grow flex gap-2 ml-3">
            <button type="button" onclick="document.getElementById('detail-add-to-cart').click()" class="flex-1 bg-[#FAF6F0] border border-[#C49A6C]/30 text-[#C49A6C] font-bold h-11 rounded-xl text-xs uppercase tracking-wider active:bg-gray-50 transition-all duration-300">
                Add to Cart
            </button>
            <button type="button" onclick="document.getElementById('detail-buy-now').click()" class="flex-1 bg-gradient-to-r from-[#C49A6C] to-[#b0875b] text-white font-bold h-11 rounded-xl text-xs uppercase tracking-wider active:scale-95 transition-all duration-300">
                Buy Now
            </button>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qtyInput = document.getElementById('qty-input');
            const stickyQty = document.getElementById('qty-input-sticky');
            const qtyPlus = document.getElementById('qty-plus');
            const qtyMinus = document.getElementById('qty-minus');

            if (qtyPlus && qtyInput && stickyQty) {
                qtyPlus.addEventListener('click', () => {
                    stickyQty.value = qtyInput.value;
                });
            }
            if (qtyMinus && qtyInput && stickyQty) {
                qtyMinus.addEventListener('click', () => {
                    stickyQty.value = qtyInput.value;
                });
            }

            // Share Product Logic
            const shareBtn = document.getElementById('share-btn');
            if (shareBtn) {
                shareBtn.addEventListener('click', async () => {
                    const title = shareBtn.getAttribute('data-title');
                    const url = shareBtn.getAttribute('data-url');
                    
                    if (navigator.share) {
                        try {
                            await navigator.share({
                                title: title,
                                url: url
                            });
                        } catch (err) {
                            console.log('Share cancelled or failed:', err);
                        }
                    } else {
                        // Fallback: Copy to clipboard and show premium toast
                        navigator.clipboard.writeText(url).then(() => {
                            showToast("Product link copied to clipboard!");
                        }).catch(err => {
                            console.error('Failed to copy link:', err);
                        });
                    }
                });
            }

            function showToast(message) {
                let toastContainer = document.getElementById('toast-container');
                if (!toastContainer) {
                    toastContainer = document.createElement('div');
                    toastContainer.id = 'toast-container';
                    toastContainer.className = 'fixed bottom-5 right-5 z-50 space-y-2';
                    document.body.appendChild(toastContainer);
                }
                
                const toast = document.createElement('div');
                toast.className = 'bg-gray-900/95 backdrop-blur-md text-white border border-[#C49A6C]/30 px-5 py-3 rounded-2xl shadow-xl flex items-center gap-3 transform translate-y-4 opacity-0 transition-all duration-300 text-xs sm:text-sm font-sans font-medium';
                toast.innerHTML = `
                    <i class="fa-solid fa-circle-check text-[#C49A6C] text-base"></i>
                    <span>${message}</span>
                `;
                
                toastContainer.appendChild(toast);
                
                // Animate entry
                setTimeout(() => {
                    toast.classList.remove('translate-y-4', 'opacity-0');
                }, 10);
                
                // Auto exit
                setTimeout(() => {
                    toast.classList.add('translate-y-4', 'opacity-0');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);
            }
        });
    </script>
    @endpush
@endsection
