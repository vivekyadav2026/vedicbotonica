@extends('layouts.frontend')

@section('title', 'Checkout')

@section('content')
    @php
        $address1 = '';
        $address2 = '';
        if (auth()->check() && auth()->user()->address) {
            $parts = explode("\n", auth()->user()->address, 2);
            $address1 = $parts[0] ?? '';
            $address2 = $parts[1] ?? '';
            
            if (empty($address2) && str_contains($address1, ',')) {
                $parts = explode(',', $address1, 2);
                $address1 = trim($parts[0]);
                $address2 = trim($parts[1]);
            }
        }
    @endphp
    <!-- Page Header -->
    <div class="bg-[#fdfaf6] py-5 md:py-12 text-center border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[10px] md:text-sm text-gray-500 uppercase tracking-widest leading-relaxed">
                <a href="/" class="hover:text-primary transition">Home</a> / 
                <span class="text-gray-900 font-medium">Checkout</span>
            </p>
            <h1 class="text-2xl sm:text-4xl font-serif font-bold text-gray-900 mt-1 md:mt-2">Checkout</h1>
        </div>
    </div>

    <!-- Flash Messages (cancel/error/warning) -->
    @if(session('warning'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
                <i class="fa-solid fa-triangle-exclamation mt-0.5 text-amber-500"></i>
                <span>{{ session('warning') }}</span>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="flex items-start gap-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
                <i class="fa-solid fa-circle-xmark mt-0.5 text-rose-500"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Checkout Form -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-8">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @guest
            <div class="mb-8 p-6 bg-[#FAF6F0] border border-[#C49A6C]/30 rounded-xl flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm">
                <div class="flex items-center space-x-3.5">
                    <div class="h-10 w-10 rounded-full bg-[#C49A6C]/10 flex items-center justify-center text-primary flex-shrink-0">
                        <i class="fa-regular fa-user text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-serif font-bold text-gray-900 text-sm">Guest Checkout Mode</h4>
                        <p class="text-xs text-gray-500 mt-0.5">You can complete your checkout without registering an account. Already have an account? <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Log in here</a>.</p>
                    </div>
                </div>
                <span class="text-[10px] text-[#C49A6C] font-bold bg-[#C49A6C]/10 px-3 py-1.5 rounded-full uppercase tracking-wider whitespace-nowrap">Instant Checkout</span>
            </div>
        @endguest

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                <!-- Shipping details form -->
                <div class="w-full lg:w-2/3">
                    <h2 class="text-xl sm:text-2xl font-serif font-bold text-gray-900 mb-6 pb-2 border-b border-gray-150">Shipping Details</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6 mb-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->check() ? auth()->user()->name : '') }}" required class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="shipping_email" value="{{ old('shipping_email', auth()->check() ? auth()->user()->email : '') }}" required class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6 mb-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Phone Number <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone', auth()->check() ? auth()->user()->phone : '') }}" required class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200" placeholder="+91">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">ZIP / Postal Code <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_zip" value="{{ old('shipping_zip', auth()->check() ? auth()->user()->zip : '') }}" required class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Flat / House No. / Building / Apartment <span class="text-red-500">*</span></label>
                            <button type="button" id="detect-location-btn" class="text-xs text-primary font-bold hover:underline flex items-center gap-1 cursor-pointer" style="color: #C49A6C;">
                                <i class="fa-solid fa-location-crosshairs"></i> Detect Location
                            </button>
                        </div>
                        <input type="text" name="shipping_address" value="{{ old('shipping_address', $address1) }}" required class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200" placeholder="e.g. Flat 104, Building A, Shanti Vihar">
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Area / Colony / Street / Sector / Landmark <span class="text-red-500">*</span></label>
                        <input type="text" name="shipping_address2" value="{{ old('shipping_address2', $address2) }}" required class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200" placeholder="e.g. Sector 12, near Kali Temple, Dwarka">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6 mb-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">City <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_city" value="{{ old('shipping_city', auth()->check() ? auth()->user()->city : '') }}" required class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">State <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_state" value="{{ old('shipping_state', auth()->check() ? auth()->user()->state : '') }}" required class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Order Notes (Optional)</label>
                        <textarea name="notes" rows="3" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200" placeholder="Notes about your order, e.g. special delivery instructions.">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Payment Methods -->
                    <h2 class="text-xl sm:text-2xl font-serif font-bold text-gray-900 mb-6 pb-2 border-b border-gray-150">Payment Method</h2>
                    <div class="space-y-4">
                        <label class="flex items-center p-4 border border-gray-250 bg-white rounded-xl cursor-pointer hover:bg-gray-50 transition shadow-sm">
                            <input type="radio" name="payment_method" value="cod" checked class="h-4 w-4 text-primary focus:ring-primary border-gray-300 cursor-pointer" style="color: #C49A6C;">
                            <span class="ml-3 font-semibold text-gray-900 text-sm">Cash on Delivery (COD)</span>
                        </label>
                        <label class="flex items-center p-4 border border-gray-250 bg-white rounded-xl cursor-pointer hover:bg-gray-50 transition shadow-sm">
                            <input type="radio" name="payment_method" value="razorpay" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 cursor-pointer" style="color: #C49A6C;">
                            <div class="ml-3">
                                <span class="font-semibold text-gray-900 text-sm">Pay Online (Razorpay - Card/UPI/NetBanking)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Order summary -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-[#fdfaf6] border border-gray-200 rounded-xl p-6 sm:p-8 sticky top-28 shadow-sm">
                        <h3 class="text-xl sm:text-2xl font-serif font-bold text-gray-900 mb-6 border-b border-gray-200 pb-4">Your Order</h3>
                        
                        <div class="divide-y divide-gray-250 max-h-80 overflow-y-auto mb-6">
                            @foreach($cart as $id => $item)
                                <div class="flex justify-between items-center py-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-contain border rounded-lg p-1 bg-white">
                                        <div>
                                            <h4 class="font-semibold text-gray-955 text-sm leading-tight max-w-[150px] truncate">{{ $item['name'] }}</h4>
                                            <span class="text-xs text-gray-500">Qty: {{ $item['quantity'] }}</span>
                                        </div>
                                    </div>
                                    <span class="font-bold text-gray-900 text-sm">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4 mb-6 border-t border-gray-250 pt-4">
                            <div class="flex justify-between text-gray-650 text-sm sm:text-base">
                                <span>Subtotal</span>
                                <span class="font-medium text-gray-900">₹{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-655 text-sm sm:text-base">
                                <span>Shipping</span>
                                <span class="text-green-600 font-medium">FREE</span>
                            </div>
                            <hr class="border-gray-200">
                            <div class="flex justify-between text-base sm:text-lg font-bold text-gray-900">
                                <span>Grand Total</span>
                                <span>₹{{ number_format($subtotal, 2) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 rounded-xl tracking-wider text-xs sm:text-sm transition-colors shadow cursor-pointer" style="background-color: #C49A6C; color: white;">
                            PLACE ORDER (₹{{ number_format($subtotal, 2) }})
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('detect-location-btn').addEventListener('click', function() {
        const btn = this;
        const originalText = btn.innerHTML;
        
        if (!navigator.geolocation) {
            alert('Geolocation is not supported by your browser.');
            return;
        }
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Detecting...';
        
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            
            // Call OpenStreetMap Nominatim reverse geocoding API
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&addressdetails=1`)
                .then(response => response.json())
                .then(data => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    
                    if (data && data.address) {
                        const addr = data.address;
                        
                        // Line 1: building/house number
                        const line1Parts = [
                            addr.house_number,
                            addr.building,
                            addr.road,
                        ].filter(Boolean);
                        const line1 = line1Parts.join(', ') || addr.road || '';
                        
                        // Line 2: area, colony, landmark
                        const line2Parts = [
                            addr.suburb,
                            addr.neighbourhood,
                            addr.village,
                            addr.city_district,
                        ].filter(Boolean);
                        const line2 = line2Parts.join(', ') || addr.county || '';
                        
                        document.querySelector('input[name="shipping_address"]').value = line1;
                        document.querySelector('input[name="shipping_address2"]').value = line2;
                        document.querySelector('input[name="shipping_city"]').value = addr.city || addr.town || addr.village || addr.county || '';
                        document.querySelector('input[name="shipping_state"]').value = addr.state || '';
                        document.querySelector('input[name="shipping_zip"]').value = addr.postcode || '';
                    } else {
                        alert('Could not resolve your address.');
                    }
                })
                .catch(error => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    alert('Error retrieving address from location.');
                });
        }, function(error) {
            btn.disabled = false;
            btn.innerHTML = originalText;
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    alert('User denied the request for Geolocation.');
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert('Location information is unavailable.');
                    break;
                case error.TIMEOUT:
                    alert('The request to get user location timed out.');
                    break;
                default:
                    alert('An unknown error occurred.');
                    break;
            }
        });
    });
</script>
@endpush
