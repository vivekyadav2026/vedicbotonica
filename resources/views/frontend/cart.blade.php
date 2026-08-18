@extends('layouts.frontend')

@section('title', 'Shopping Cart')

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
                <span class="text-gray-900 font-medium">Cart</span>
            </p>
            <h1 class="text-3xl sm:text-5xl font-serif font-bold text-gray-955 uppercase tracking-widest mt-3">Shopping Cart</h1>
            <p class="text-[10px] text-[#C49A6C] uppercase font-bold tracking-widest font-serif mt-2">Your Sacred Selections</p>
            <div class="w-16 h-[1.5px] bg-[#C49A6C] mx-auto mt-4"></div>
        </div>
    </div>

    <!-- Cart Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if(count($cart) > 0)
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                <!-- Cart Items Wrapper -->
                <div class="w-full lg:w-2/3">
                    
                    <!-- Desktop Table (hidden on mobile) -->
                    <div class="hidden md:block overflow-x-auto border border-gray-200 rounded-lg shadow-sm">
                        <table class="w-full text-left border-collapse bg-white">
                            <thead>
                                <tr class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                                    <th class="p-6">Product</th>
                                    <th class="p-6">Price</th>
                                    <th class="p-6 text-center">Quantity</th>
                                    <th class="p-6">Total</th>
                                    <th class="p-6">Remove</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @php $subtotal = 0; @endphp
                                @foreach($cart as $id => $item)
                                    @php 
                                        $itemTotal = $item['price'] * $item['quantity']; 
                                        $subtotal += $itemTotal;
                                    @endphp
                                    <tr class="cart-item-row text-gray-700 align-middle" data-id="{{ $id }}">
                                        <td class="p-6 flex items-start space-x-4">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-contain border rounded p-1 mt-1 flex-shrink-0">
                                            <div class="min-w-0 flex-1">
                                                @if(isset($item['is_bundle']) && $item['is_bundle'])
                                                    <span class="font-serif font-bold text-gray-900 text-sm sm:text-base block">{{ $item['name'] }}</span>
                                                    
                                                    <!-- Sub-items List -->
                                                    <div class="mt-2.5 space-y-1.5 bg-slate-50 p-2.5 rounded-xl border border-slate-100/70 max-w-sm">
                                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Included Items:</span>
                                                        @foreach($item['bundle_items'] as $subItem)
                                                            <div class="flex items-center space-x-2 text-xs text-slate-700 font-sans">
                                                                <img src="{{ $subItem['image'] }}" alt="{{ $subItem['name'] }}" class="w-6 h-6 object-contain border rounded bg-white p-0.5">
                                                                <span class="truncate flex-grow font-medium">{{ $subItem['name'] }}</span>
                                                                <span class="font-bold text-slate-500 whitespace-nowrap">Qty: {{ $subItem['quantity'] }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <a href="/product/{{ $item['slug'] }}" class="font-serif font-semibold text-gray-900 hover:text-[#C49A6C] transition text-sm sm:text-base block">{{ $item['name'] }}</a>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="p-6 font-medium">₹{{ number_format($item['price'], 2) }}</td>
                                        <td class="p-6">
                                            <div class="flex items-center justify-center border border-gray-200 rounded w-32 mx-auto bg-white">
                                                <button type="button" class="w-10 h-10 text-gray-600 hover:bg-gray-100 qty-btn-minus" data-id="{{ $id }}"><i class="fa-solid fa-minus text-xs"></i></button>
                                                <input type="number" class="w-12 h-10 text-center border-none focus:ring-0 text-sm qty-input-val" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}" data-id="{{ $id }}">
                                                <button type="button" class="w-10 h-10 text-gray-600 hover:bg-gray-100 qty-btn-plus" data-id="{{ $id }}"><i class="fa-solid fa-plus text-xs"></i></button>
                                            </div>
                                        </td>
                                        <td class="p-6 font-bold text-gray-900">₹<span class="item-total-price" data-id="{{ $id }}">{{ number_format($itemTotal, 2) }}</span></td>
                                        <td class="p-6 text-center">
                                            <button type="button" class="text-gray-400 hover:text-red-500 transition-colors btn-remove-item cursor-pointer" data-id="{{ $id }}"><i class="fa-regular fa-trash-can text-lg"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards List (hidden on desktop) -->
                    <div class="block md:hidden space-y-4">
                        @php $subtotal = 0; @endphp
                        @foreach($cart as $id => $item)
                            @php 
                                $itemTotal = $item['price'] * $item['quantity']; 
                                $subtotal += $itemTotal;
                            @endphp
                            <div class="cart-item-row bg-white border border-gray-200 rounded-2xl p-4 flex gap-4 relative" data-id="{{ $id }}">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-contain border rounded-xl p-1 bg-gray-50 flex-shrink-0">
                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start gap-2">
                                            @if(isset($item['is_bundle']) && $item['is_bundle'])
                                                <span class="font-serif font-bold text-gray-900 text-sm sm:text-base leading-tight">{{ $item['name'] }}</span>
                                            @else
                                                <a href="/product/{{ $item['slug'] }}" class="font-serif font-bold text-gray-900 hover:text-[#C49A6C] transition text-sm sm:text-base leading-tight">{{ $item['name'] }}</a>
                                            @endif
                                            <button type="button" class="text-gray-400 hover:text-red-500 transition-colors btn-remove-item cursor-pointer" data-id="{{ $id }}">
                                                <i class="fa-regular fa-trash-can text-base"></i>
                                            </button>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">₹{{ number_format($item['price'], 2) }}</p>
                                        
                                        @if(isset($item['is_bundle']) && $item['is_bundle'])
                                            <!-- Sub-items List (Mobile) -->
                                            <div class="mt-2.5 space-y-1.5 bg-slate-50 p-2 border border-slate-100/70 rounded-xl">
                                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Included Items:</span>
                                                @foreach($item['bundle_items'] as $subItem)
                                                    <div class="flex items-center space-x-2 text-xs text-slate-700 font-sans">
                                                        <img src="{{ $subItem['image'] }}" alt="{{ $subItem['name'] }}" class="w-6 h-6 object-contain border rounded bg-white p-0.5">
                                                        <span class="truncate flex-grow font-medium">{{ $subItem['name'] }}</span>
                                                        <span class="font-bold text-slate-500 whitespace-nowrap text-[10px]">Qty: {{ $subItem['quantity'] }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex items-center justify-between mt-3">
                                        <!-- Quantity controls -->
                                        <div class="flex items-center border border-gray-200 rounded-xl bg-gray-50 overflow-hidden">
                                            <button type="button" class="w-8 h-8 text-gray-600 hover:bg-gray-150 transition qty-btn-minus" data-id="{{ $id }}"><i class="fa-solid fa-minus text-xs"></i></button>
                                            <input type="number" class="w-10 h-8 text-center border-none bg-transparent focus:ring-0 text-xs qty-input-val" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}" data-id="{{ $id }}">
                                            <button type="button" class="w-8 h-8 text-gray-600 hover:bg-gray-150 transition qty-btn-plus" data-id="{{ $id }}"><i class="fa-solid fa-plus text-xs"></i></button>
                                        </div>
                                        <!-- Subtotal price -->
                                        <p class="text-base font-bold text-gray-955">₹<span class="item-total-price" data-id="{{ $id }}">{{ number_format($itemTotal, 2) }}</span></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

                <!-- Order Summary -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-[#fdfaf6] border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm">
                        <h3 class="text-xl sm:text-2xl font-serif font-bold text-gray-900 mb-6 border-b border-gray-200 pb-4">Order Summary</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-600 text-sm sm:text-base">
                                <span>Subtotal</span>
                                <span class="font-medium text-gray-900">₹<span id="cart-subtotal">{{ number_format($subtotal, 2) }}</span></span>
                            </div>
                            <div class="flex justify-between text-gray-600 text-sm sm:text-base">
                                <span>Shipping</span>
                                <span class="text-green-600 font-medium">FREE</span>
                            </div>
                            <hr class="border-gray-200">
                            <div class="flex justify-between text-base sm:text-lg font-bold text-gray-900">
                                <span>Grand Total</span>
                                <span>₹<span id="cart-grandtotal">{{ number_format($subtotal, 2) }}</span></span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 rounded-xl tracking-wider text-xs sm:text-sm transition-colors shadow cursor-pointer" style="background-color: #C49A6C; color: white;">
                            PROCEED TO CHECKOUT
                        </a>
                        <a href="/shop" class="block text-center w-full mt-4 text-xs sm:text-sm text-primary hover:text-primary-dark font-medium transition-colors">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-[#fdfaf6] rounded-xl border border-dashed border-gray-300">
                <i class="fa-solid fa-cart-shopping text-6xl text-gray-300 mb-6"></i>
                <h2 class="text-2xl font-serif font-bold text-gray-900 mb-2">Your Cart is Empty</h2>
                <p class="text-gray-500 mb-8 max-w-sm mx-auto">Looks like you haven't added any products to your shopping cart yet.</p>
                <a href="/shop" class="inline-block bg-primary hover:bg-primary-dark text-white font-bold px-8 py-4 rounded tracking-wider text-sm transition shadow" style="background-color: #C49A6C; color: white;">
                    SHOP OUR PRODUCTS
                </a>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Helper to update totals
        function updateUIPrices(cartCount, subtotal, cartData) {
            // Update cart badges
            if (window.updateCartBadges) {
                window.updateCartBadges(cartCount);
            } else {
                const badge = document.getElementById('cart-count-badge');
                if (badge) badge.textContent = cartCount;
                const badgeMobile = document.getElementById('cart-count-badge-mobile');
                if (badgeMobile) badgeMobile.textContent = cartCount;
            }

            // If subtotal elements exist
            const subtotalEl = document.getElementById('cart-subtotal');
            const grandtotalEl = document.getElementById('cart-grandtotal');
            if (subtotalEl) subtotalEl.textContent = parseFloat(subtotal).toFixed(2);
            if (grandtotalEl) grandtotalEl.textContent = parseFloat(subtotal).toFixed(2);

            // Update item row subtotals
            if (cartData) {
                Object.keys(cartData).forEach(id => {
                    const item = cartData[id];
                    const itemTotalSpan = document.querySelector(`.item-total-price[data-id="${id}"]`);
                    if (itemTotalSpan) {
                        itemTotalSpan.textContent = parseFloat(item.price * item.quantity).toFixed(2);
                    }
                });
            }

            if (parseInt(cartCount) === 0) {
                location.reload(); // Reload to show empty cart message
            }
        }

        // Handle Minus Button
        document.body.addEventListener('click', function(e) {
            const minusBtn = e.target.closest('.qty-btn-minus');
            if (minusBtn) {
                const id = minusBtn.getAttribute('data-id');
                const inputs = document.querySelectorAll(`.qty-input-val[data-id="${id}"]`);
                let val = parseInt(inputs[0].value) - 1;
                if (val < 1) val = 0;
                
                inputs.forEach(input => input.value = val);
                updateQuantity(id, val);
            }
        });

        // Handle Plus Button
        document.body.addEventListener('click', function(e) {
            const plusBtn = e.target.closest('.qty-btn-plus');
            if (plusBtn) {
                const id = plusBtn.getAttribute('data-id');
                const inputs = document.querySelectorAll(`.qty-input-val[data-id="${id}"]`);
                const max = parseInt(inputs[0].getAttribute('max')) || Infinity;
                let val = parseInt(inputs[0].value) + 1;
                if (val > max) val = max;
                
                inputs.forEach(input => input.value = val);
                updateQuantity(id, val);
            }
        });

        // Handle Manual Input Change
        document.body.addEventListener('change', function(e) {
            const input = e.target.closest('.qty-input-val');
            if (input) {
                const id = input.getAttribute('data-id');
                const max = parseInt(input.getAttribute('max')) || Infinity;
                let val = parseInt(input.value);
                if (isNaN(val) || val < 1) val = 1;
                if (val > max) val = max;
                
                const inputs = document.querySelectorAll(`.qty-input-val[data-id="${id}"]`);
                inputs.forEach(inp => inp.value = val);
                updateQuantity(id, val);
            }
        });

        // Handle Remove Button
        document.body.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.btn-remove-item');
            if (removeBtn) {
                const id = removeBtn.getAttribute('data-id');
                if (confirm('Are you sure you want to remove this item?')) {
                    removeItem(id);
                }
            }
        });

        // AJAX Update Quantity
        function updateQuantity(productId, quantity) {
            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(data => { throw new Error(data.message || 'Server error'); });
                }
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    if (quantity === 0) {
                        const items = document.querySelectorAll(`.cart-item-row[data-id="${productId}"]`);
                        items.forEach(item => item.remove());
                    }
                    updateUIPrices(data.cart_count, data.total_price, data.cart);
                }
            })
            .catch(err => {
                console.error(err);
                if (typeof showToast === 'function') {
                    showToast(err.message, false);
                } else {
                    alert(err.message);
                }
                setTimeout(() => {
                    location.reload();
                }, 1500);
            });
        }

        // AJAX Remove Item
        function removeItem(productId) {
            fetch('/cart/remove', {
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
                    const items = document.querySelectorAll(`.cart-item-row[data-id="${productId}"]`);
                    items.forEach(item => item.remove());
                    updateUIPrices(data.cart_count, data.total_price, data.cart);
                }
            })
            .catch(err => console.error(err));
        }
    });
</script>
@endpush
