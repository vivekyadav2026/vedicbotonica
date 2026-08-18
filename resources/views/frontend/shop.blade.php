@extends('layouts.frontend')

@section('title', 'Vedic Botanica Shop - Buy Pure Cow Dung Dhoop Sticks & Cones')
@section('meta_description', 'Browse the complete collection of organic, charcoal-free dhoop sticks and cones from Vedic Botanica. Elevate your pooja, home ambiance, and meditation rituals.')
@section('meta_keywords', 'Vedic Botanica shop, buy dhoop online, organic pooja items, natural incense cones, buy premium combos, clean air incense')

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
                <span class="text-gray-900 font-medium">Shop</span>
            </p>
            <h1 class="text-3xl sm:text-5xl font-serif font-bold text-gray-955 uppercase tracking-widest mt-3">Shop</h1>
            <p class="text-[10px] text-[#C49A6C] uppercase font-bold tracking-widest font-serif mt-2">Elevate Your Spiritual Aura</p>
            <div class="w-16 h-[1.5px] bg-[#C49A6C] mx-auto mt-4"></div>
        </div>
    </div>

    <!-- Shop Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-12" x-data="{ filtersOpen: false }">
        
        <!-- Mobile Filter Trigger Button -->
        <div class="flex lg:hidden justify-between items-center mb-6 gap-4">
            <button @click="filtersOpen = !filtersOpen" 
                    class="flex-1 bg-white border border-[#C49A6C]/30 text-gray-800 py-3 px-4 rounded-xl flex items-center justify-center space-x-2 text-sm font-semibold shadow-sm hover:bg-gray-50 active:scale-95 transition-all">
                <i class="fa-solid fa-sliders text-[#C49A6C]"></i>
                <span x-text="filtersOpen ? 'Hide Filters' : 'Show Filters'">Show Filters</span>
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-10">
            
            <!-- Sidebar -->
            <div :class="filtersOpen ? 'block' : 'hidden lg:block'" class="w-full lg:w-1/4 transition-all duration-300">
                <form method="GET" action="{{ route('shop') }}" id="filter-form" class="space-y-8">
                    <!-- Preserve Highlight parameter -->
                    @if(request('highlight'))
                        <input type="hidden" name="highlight" value="{{ request('highlight') }}">
                    @endif
                    <input type="hidden" name="sort_by" id="filter_sort_by" value="{{ request('sort_by', 'default') }}">
                    
                    <!-- Categories Filter -->
                    <div class="border border-[#C49A6C]/30 bg-[#FAF6F0]/30 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-lg font-serif font-bold text-gray-900 mb-4 pb-2 border-b border-[#C49A6C]/20 flex justify-between items-center">
                            Shop By Categories
                            <i class="fa-solid fa-minus text-gray-400 text-sm"></i>
                        </h3>
                        <div class="space-y-3">
                            @foreach($categories as $category)
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                       @checked(in_array($category->id, request('categories', []))) 
                                       onchange="document.getElementById('filter-form').submit()" 
                                       class="form-checkbox h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary">
                                <span class="text-gray-650 group-hover:text-primary transition text-sm">
                                    {{ $category->name }} ({{ $category->products()->count() }})
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Highlight Filter -->
                    <div class="border border-[#C49A6C]/30 bg-[#FAF6F0]/30 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-lg font-serif font-bold text-gray-900 mb-4 pb-2 border-b border-[#C49A6C]/20 flex justify-between items-center">
                            Highlight
                            <i class="fa-solid fa-minus text-gray-400 text-sm"></i>
                        </h3>
                        <ul class="space-y-3">
                            <li><a href="{{ route('shop', ['highlight' => 'all'] + request()->except('highlight', 'page')) }}" class="text-sm transition {{ !request('highlight') || request('highlight') == 'all' ? 'text-primary font-bold' : 'text-gray-600 hover:text-primary' }}">All Products</a></li>
                            <li><a href="{{ route('shop', ['highlight' => 'bestseller'] + request()->except('highlight', 'page')) }}" class="text-sm transition {{ request('highlight') == 'bestseller' ? 'text-primary font-bold' : 'text-gray-600 hover:text-primary' }}">Best Seller</a></li>
                            <li><a href="{{ route('shop', ['highlight' => 'new'] + request()->except('highlight', 'page')) }}" class="text-sm transition {{ request('highlight') == 'new' ? 'text-primary font-bold' : 'text-gray-600 hover:text-primary' }}">New Arrivals</a></li>
                            <li><a href="{{ route('shop', ['highlight' => 'sale'] + request()->except('highlight', 'page')) }}" class="text-sm transition {{ request('highlight') == 'sale' ? 'text-primary font-bold' : 'text-gray-600 hover:text-primary' }}">Sale</a></li>
                        </ul>
                    </div>

                    <!-- Price Filter -->
                    <div class="border border-[#C49A6C]/30 bg-[#FAF6F0]/30 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-lg font-serif font-bold text-gray-900 mb-4 pb-2 border-b border-[#C49A6C]/20 flex justify-between items-center">
                            Price Filter
                            <i class="fa-solid fa-minus text-gray-400 text-sm"></i>
                        </h3>
                        <div class="space-y-3">
                            @php $priceRange = request('price_range'); @endphp
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="radio" name="price_range" value="all" @checked(!$priceRange || $priceRange == 'all') onchange="document.getElementById('filter-form').submit()" class="form-radio h-4 w-4 text-primary border-gray-300 focus:ring-[#C49A6C]">
                                <span class="text-gray-650 group-hover:text-primary transition text-sm">All Prices</span>
                            </label>
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="radio" name="price_range" value="under_200" @checked($priceRange == 'under_200') onchange="document.getElementById('filter-form').submit()" class="form-radio h-4 w-4 text-primary border-gray-300 focus:ring-[#C49A6C]">
                                <span class="text-gray-650 group-hover:text-primary transition text-sm">Under ₹200</span>
                            </label>
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="radio" name="price_range" value="200_300" @checked($priceRange == '200_300') onchange="document.getElementById('filter-form').submit()" class="form-radio h-4 w-4 text-primary border-gray-300 focus:ring-[#C49A6C]">
                                <span class="text-gray-650 group-hover:text-primary transition text-sm">₹200 - ₹300</span>
                            </label>
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="radio" name="price_range" value="above_300" @checked($priceRange == 'above_300') onchange="document.getElementById('filter-form').submit()" class="form-radio h-4 w-4 text-primary border-gray-300 focus:ring-[#C49A6C]">
                                <span class="text-gray-650 group-hover:text-primary transition text-sm">Above ₹300</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Product Grid -->
            <div class="w-full lg:w-3/4" x-data="{ viewMode: localStorage.getItem('shop_view_mode') || 'grid' }">
                
                <!-- Toolbar -->
                <div class="flex flex-col sm:flex-row justify-between items-center mb-8 bg-[#FAF6F0] p-4 rounded-xl border border-[#C49A6C]/30 shadow-sm">
                    <p class="text-sm text-gray-500 mb-4 sm:mb-0">
                        Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                    </p>
                    <div class="flex items-center space-x-4">
                        <select onchange="document.getElementById('filter_sort_by').value = this.value; document.getElementById('filter-form').submit()" class="border-gray-300 rounded-md text-sm text-gray-600 focus:ring-[#C49A6C] focus:border-[#C49A6C]">
                            <option value="default" {{ request('sort_by', 'default') == 'default' ? 'selected' : '' }}>Default sorting</option>
                            <option value="latest" {{ request('sort_by') == 'latest' ? 'selected' : '' }}>Sort by latest</option>
                            <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Price: low to high</option>
                            <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Price: high to low</option>
                        </select>
                        <div class="flex space-x-2">
                            <button 
                                @click="viewMode = 'grid'; localStorage.setItem('shop_view_mode', 'grid')" 
                                :class="viewMode === 'grid' ? 'bg-[#C49A6C] text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50'" 
                                class="p-2 rounded h-9 w-9 flex items-center justify-center shadow-sm transition duration-200" 
                                title="Grid View">
                                <i class="fa-solid fa-border-all"></i>
                            </button>
                            <button 
                                @click="viewMode = 'list'; localStorage.setItem('shop_view_mode', 'list')" 
                                :class="viewMode === 'list' ? 'bg-[#C49A6C] text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50'" 
                                class="p-2 rounded h-9 w-9 flex items-center justify-center shadow-sm transition duration-200" 
                                title="List View">
                                <i class="fa-solid fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Products Grid/List Container -->
                <div id="products-list-container" :class="viewMode === 'grid' ? 'grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6' : 'flex flex-col gap-6'">
                    @foreach($products as $product)
                        @include('frontend.partials.product_card', ['product' => $product])
                    @endforeach
                </div>
                
                <!-- Infinite Scroll Loader Spinner -->
                <div id="infinite-scroll-loader" class="py-12 flex flex-col justify-center items-center gap-2 hidden cursor-pointer">
                    <div class="animate-spin rounded-full h-8 w-8 border-2 border-[#C49A6C] border-t-transparent"></div>
                    <span class="loading-text text-xs text-gray-500 font-sans font-medium">Loading more products...</span>
                </div>

                <!-- Hidden pagination links wrapper to read URLs -->
                <div id="pagination-wrapper" class="hidden">
                    {{ $products->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('products-list-container');
        const loader = document.getElementById('infinite-scroll-loader');
        const paginationWrapper = document.getElementById('pagination-wrapper');
        
        if (!container || !loader || !paginationWrapper) return;
        
        let nextPageUrl = paginationWrapper.querySelector('a[rel="next"]')?.getAttribute('href');
        let loading = false;

        // If there's no next page, we don't need to observe anything
        if (!nextPageUrl) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !loading && nextPageUrl) {
                    loadMoreProducts();
                }
            });
        }, {
            rootMargin: '250px' // Start loading 250px before reaching bottom
        });

        observer.observe(loader);
        
        // Show loader spinner
        loader.classList.remove('hidden');

        async function loadMoreProducts() {
            loading = true;
            loader.querySelector('.loading-text').textContent = 'Loading more products...';
            
            try {
                const response = await fetch(nextPageUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                if (!response.ok) throw new Error('Network response was not ok');
                
                const data = await response.json();
                
                if (data.html) {
                    // Append HTML to container
                    container.insertAdjacentHTML('beforeend', data.html);
                    
                    // Update next page URL
                    nextPageUrl = data.nextPageUrl;
                    
                    // If no more pages, stop loading
                    if (!nextPageUrl) {
                        observer.disconnect();
                        loader.classList.add('hidden');
                    }
                } else {
                    observer.disconnect();
                    loader.classList.add('hidden');
                }
            } catch (error) {
                console.error('Error loading products:', error);
                loader.querySelector('.loading-text').textContent = 'Error loading products. Click to retry';
                loader.onclick = function() {
                    loader.onclick = null;
                    loadMoreProducts();
                };
            } finally {
                loading = false;
            }
        }
    });
</script>
@endpush
