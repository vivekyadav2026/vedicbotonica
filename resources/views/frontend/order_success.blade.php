@extends('layouts.frontend')

@section('title', 'Order Success')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <!-- Success Animation/Icon -->
        <div class="inline-flex items-center justify-center bg-green-55 p-6 rounded-full mb-8 text-green-500 border border-green-200 shadow-md">
            <i class="fa-solid fa-circle-check text-7xl"></i>
        </div>

        <h1 class="text-4xl font-serif font-bold text-gray-900 mb-4">Order Placed Successfully!</h1>
        <p class="text-gray-500 mb-8 max-w-md mx-auto text-sm sm:text-base">Thank you for your purchase. We have received your order and are processing it. An email confirmation has been sent to <span class="font-semibold text-gray-900">{{ $order->shipping_email }}</span>.</p>

        <!-- Order Summary Card -->
        <div class="bg-[#fdfaf6] border border-gray-200 rounded-xl p-8 text-left mb-10 shadow-sm">
            <h3 class="text-xl font-serif font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200">Order Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider block">Order Number</span>
                    <span class="font-mono font-bold text-gray-950 text-base">{{ $order->order_number }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider block">Date Placed</span>
                    <span class="font-medium text-gray-900">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider block">Total Amount</span>
                    <span class="font-bold text-primary text-base">₹{{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider block">Payment Method</span>
                    <span class="font-semibold text-gray-900 uppercase text-sm">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment' }}</span>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <span class="text-xs text-gray-400 uppercase tracking-wider block mb-1">Shipping Address</span>
                <p class="text-sm text-gray-700 leading-relaxed font-medium">
                    {{ $order->shipping_name }}<br>
                    {{ $order->shipping_address }}, {{ $order->shipping_city }}<br>
                    {{ $order->shipping_state }} - {{ $order->shipping_zip }}<br>
                    Phone: {{ $order->shipping_phone }}
                </p>
            </div>
        </div>

        <!-- Call to Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/shop" class="bg-primary hover:bg-primary-dark text-white font-bold px-8 py-4 rounded tracking-wider text-sm transition shadow" style="background-color: #C49A6C; color: white;">
                CONTINUE SHOPPING
            </a>
            @if(auth()->check())
                <a href="/dashboard" class="bg-secondary hover:bg-black text-white font-bold px-8 py-4 rounded tracking-wider text-sm transition shadow">
                    GO TO DASHBOARD
                </a>
            @else
                <a href="/login" class="bg-secondary hover:bg-black text-white font-bold px-8 py-4 rounded tracking-wider text-sm transition shadow">
                    LOGIN TO TRACK ORDER
                </a>
            @endif
        </div>
    </div>
@endsection
