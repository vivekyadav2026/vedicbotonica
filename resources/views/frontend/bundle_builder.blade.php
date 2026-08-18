@extends('layouts.frontend')

@section('title', $title . ' - Custom Bundle Builder | Vedic Botanica')
@section('meta_description', 'Choose any ' . $quantity . ' premium trial packs for a flat price of ₹' . $price . '. Build your custom box now and experience nature\'s purity.')

@section('content')
<div class="bg-[#FAF6F0]/40 min-h-screen pb-32 pt-8 font-sans" x-data="bundleBuilderData()">
    <!-- Hero / Title Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 text-center">
        <span class="text-[#C49A6C] text-xs font-bold font-sans uppercase tracking-[0.2em] block mb-2">Exclusive Offer</span>
        <h1 class="text-3xl sm:text-4xl font-serif font-extrabold text-gray-900 mb-3">{{ $title }}</h1>
        <p class="text-gray-600 text-sm max-w-xl mx-auto leading-relaxed">
            1 Price. Pure Bliss. — Customize your box by selecting exactly <strong class="text-gray-900 font-semibold">{{ $quantity }} products</strong> of your choice for just <strong class="text-gray-900 font-semibold">₹{{ number_format($price) }}/-</strong>!
        </p>

        <!-- Information / Savings Banner -->
        <div class="mt-6 inline-flex items-center gap-3 bg-amber-50 border border-amber-100 rounded-2xl px-5 py-3 text-xs text-amber-800 font-medium max-w-lg shadow-xs">
            <i class="fa-solid fa-gift text-sm text-[#C49A6C]"></i>
            <span><strong>Special Deal Applied:</strong> Enjoy maximum discounts with this custom pack. No coupon code required at checkout.</span>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($products->isEmpty())
            <div class="text-center py-16 bg-white border border-gray-100 rounded-2xl shadow-xs">
                <i class="fa-solid fa-folder-open text-gray-300 text-5xl mb-3"></i>
                <p class="text-gray-500 font-serif font-medium text-lg">No products are currently eligible for this bundle.</p>
                <a href="{{ route('shop') }}" class="mt-4 inline-block bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-xs px-6 py-3 rounded-xl shadow-md transition uppercase tracking-wider">Back to Shop</a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($products as $product)
                    @php
                        $images = json_decode($product->images);
                        $image = ($images && count($images) > 0) ? asset($images[0]) : asset('images/premium_dhoop_product.png');
                        $retailPrice = $product->sale_price ?: $product->price;
                    @endphp
                    <div class="group bg-white border border-gray-100/80 rounded-2xl overflow-hidden hover:border-[#C49A6C]/30 hover:shadow-lg transition-all duration-300 flex flex-col relative">
                        <!-- Product Image Area -->
                        <div class="relative w-full aspect-square bg-[#FAF6F0]/40 flex items-center justify-center p-4">
                            <img src="{{ $image }}" alt="{{ $product->name }}" class="max-h-[85%] max-w-[85%] object-contain transition-transform duration-500 group-hover:scale-105">
                            
                            <!-- Retail Price Helper Badge -->
                            <div class="absolute top-2.5 right-2.5 bg-white/95 backdrop-blur-xs border border-gray-100 text-gray-500 text-[10px] font-bold px-2 py-0.5 rounded-md shadow-xs">
                                Value: ₹{{ number_format($retailPrice) }}
                            </div>
                        </div>

                        <!-- Product Metadata -->
                        <div class="p-3.5 sm:p-5 flex-grow flex flex-col justify-between">
                            <div class="space-y-1">
                                <h3 class="font-serif font-bold text-gray-900 text-sm sm:text-base line-clamp-1" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </h3>
                                
                                <!-- Reviews & Rating -->
                                <div class="flex items-center gap-1.5">
                                    <div class="flex text-[#C49A6C] text-[10px]">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-solid fa-star {{ $i <= $product->average_rating ? '' : 'text-gray-200' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="text-[10px] text-gray-400 font-semibold font-sans">({{ $product->reviews_count }})</span>
                                </div>

                                <p class="text-xs text-gray-400 line-clamp-2 pt-1 font-sans">
                                    {{ $product->short_description ?: 'Vedic and natural essence formulation.' }}
                                </p>
                            </div>

                            <!-- Interactive Button -->
                            <div class="mt-4 pt-3.5 border-t border-gray-50/80 flex items-center justify-between gap-2">
                                <button type="button" 
                                        @click="addItem({ id: {{ $product->id }}, name: '{{ addslashes($product->name) }}', image: '{{ $image }}' })"
                                        class="w-full bg-slate-50 hover:bg-[#C49A6C] hover:text-white text-gray-800 font-bold text-xs px-4 py-2.5 rounded-xl border border-gray-150 transition cursor-pointer flex items-center justify-center gap-1.5 uppercase tracking-wider"
                                        id="add_to_box_btn_{{ $product->id }}">
                                    <i class="fa-solid fa-plus text-[10px]"></i>
                                    <span>Add to Box</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Sticky Selection Progress Footer Bar -->
    <div class="fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-gray-100 shadow-2xl py-4 sm:py-5 z-40 transition-transform duration-300"
         x-show="selectedItems.length > 0"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="transform translate-y-full"
         x-transition:enter-end="transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="transform translate-y-0"
         x-transition:leave-end="transform translate-y-full"
         style="display: none;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                
                <!-- Left: Status text & Slots Drawer -->
                <div class="flex-grow flex flex-col sm:flex-row sm:items-center gap-3.5">
                    <div class="min-w-[150px]">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-0.5">Your Box</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-lg font-serif font-black text-gray-900" x-text="selectedItems.length + ' / ' + maxQty"></span>
                            <span class="text-xs text-gray-500 font-medium" x-text="selectedItems.length < maxQty ? 'Selected' : 'Bundle Complete!'"></span>
                        </div>
                    </div>

                    <!-- Slots Circle List -->
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-thin">
                        <template x-for="index in Array.from({length: maxQty})">
                            <div class="relative w-12 h-12 rounded-full flex-shrink-0 transition-all duration-300">
                                <!-- Empty Slot state -->
                                <div class="absolute inset-0 rounded-full border border-dashed border-gray-300 bg-gray-50/50 flex items-center justify-center text-gray-300" 
                                     x-show="index >= selectedItems.length">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </div>
                                <!-- Filled Slot state -->
                                <div class="absolute inset-0 rounded-full border border-solid border-[#C49A6C]/40 bg-white p-0.5" 
                                     x-show="index < selectedItems.length">
                                    <img :src="selectedItems[index]?.image" class="w-full h-full object-contain rounded-full">
                                    <!-- Delete circle icon button -->
                                    <button type="button" 
                                            @click="removeItemAt(index)"
                                            class="absolute -top-1.5 -right-1.5 bg-gray-900 text-white rounded-full w-4.5 h-4.5 flex items-center justify-center shadow-md border border-white hover:bg-red-600 transition cursor-pointer"
                                            title="Remove product from box">
                                        <i class="fa-solid fa-xmark text-[8px]"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Right: Pricing summary & CTA checkout -->
                <div class="flex items-center justify-between sm:justify-end gap-5 border-t lg:border-t-0 pt-3 lg:pt-0 border-gray-100">
                    <div class="text-left sm:text-right">
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block">Flat Price</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-xl font-serif font-black text-gray-900">₹{{ number_format($price) }}</span>
                            <span class="text-[10px] text-emerald-700 font-semibold uppercase tracking-wider block sm:inline">Combo Discounted</span>
                        </div>
                    </div>

                    <button type="button"
                            @click="submitBundle()"
                            :disabled="selectedItems.length !== maxQty || submitting"
                            class="bg-[#C49A6C] disabled:bg-gray-200 disabled:text-gray-400 disabled:border-gray-200 disabled:cursor-not-allowed hover:bg-[#b0875b] text-white font-bold text-xs uppercase tracking-wider px-6 py-3.5 rounded-xl transition shadow-lg shadow-[#C49A6C]/20 flex items-center gap-2 cursor-pointer border border-[#C49A6C]"
                            id="add_bundle_to_cart_btn">
                        <template x-if="submitting">
                            <i class="fa-solid fa-circle-notch fa-spin text-sm"></i>
                        </template>
                        <template x-if="!submitting">
                            <i class="fa-solid fa-basket-shopping text-sm"></i>
                        </template>
                        <span x-text="submitting ? 'Adding Bundle...' : (selectedItems.length < maxQty ? 'Select ' + (maxQty - selectedItems.length) + ' More' : 'Add Box to Cart')"></span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function bundleBuilderData() {
        return {
            selectedItems: [],
            maxQty: {{ $quantity }},
            submitting: false,

            addItem(item) {
                if (this.selectedItems.length >= this.maxQty) {
                    this.showToast("Your box is already full! Remove an item to add another.", "warning");
                    return;
                }
                this.selectedItems.push(item);
                this.showToast(`"${item.name}" added to box.`, "success");
            },

            removeItemAt(index) {
                if (index > -1 && index < this.selectedItems.length) {
                    const removed = this.selectedItems.splice(index, 1);
                    this.showToast(`Removed "${removed[0].name}" from box.`, "info");
                }
            },

            submitBundle() {
                if (this.selectedItems.length !== this.maxQty) {
                    this.showToast(`You must select exactly ${this.maxQty} products.`, "error");
                    return;
                }
                
                this.submitting = true;
                const productIds = this.selectedItems.map(item => item.id);

                fetch("{{ route('cart.add-bundle') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_ids: productIds
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.showToast(data.message || 'Bundle added to cart!', 'success');
                        
                        const headerCartBadge = document.querySelector('.cart-badge');
                        if (headerCartBadge && data.cart_count) {
                            headerCartBadge.textContent = data.cart_count;
                        }
                        
                        setTimeout(() => {
                            window.location.href = "{{ route('cart.index') }}";
                        }, 1000);
                    } else {
                        this.showToast(data.message || 'Failed to add bundle to cart.', 'error');
                        this.submitting = false;
                    }
                })
                .catch(err => {
                    console.error(err);
                    this.showToast('Something went wrong. Please try again.', 'error');
                    this.submitting = false;
                });
            },

            showToast(message, type = "success") {
                if (window.showToastNotification) {
                    window.showToastNotification(message, type);
                } else {
                    console.log(`[Toast ${type}]: ${message}`);
                    
                    const toast = document.createElement('div');
                    toast.className = `fixed top-5 right-5 z-50 px-4 py-3 rounded-xl shadow-xl text-white font-sans text-xs flex items-center gap-2 border transition-all duration-300 transform translate-y-[-10px] opacity-0`;
                    
                    let bg = 'bg-gray-900 border-gray-800';
                    let icon = '<i class="fa-solid fa-circle-info"></i>';
                    
                    if (type === 'success') {
                        bg = 'bg-emerald-600 border-emerald-500';
                        icon = '<i class="fa-solid fa-circle-check"></i>';
                    } else if (type === 'error') {
                        bg = 'bg-rose-600 border-rose-500';
                        icon = '<i class="fa-solid fa-circle-exclamation"></i>';
                    } else if (type === 'warning') {
                        bg = 'bg-amber-600 border-amber-500';
                        icon = '<i class="fa-solid fa-triangle-exclamation"></i>';
                    }
                    
                    toast.className += ` ${bg}`;
                    toast.innerHTML = `${icon} <span>${message}</span>`;
                    
                    document.body.appendChild(toast);
                    
                    setTimeout(() => {
                        toast.classList.remove('opacity-0', 'translate-y-[-10px]');
                        toast.classList.add('opacity-100', 'translate-y-0');
                    }, 50);
                    
                    setTimeout(() => {
                        toast.classList.add('opacity-0', 'translate-y-[-10px]');
                        setTimeout(() => toast.remove(), 300);
                    }, 3000);
                }
            }
        };
    }
</script>
@endpush
@endsection
