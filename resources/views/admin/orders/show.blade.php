@extends('layouts.admin')

@section('header_title', 'Order Details')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h3 class="font-serif font-bold text-slate-800 text-lg">Order: {{ $order->order_number }}</h3>
            <span class="text-xs text-slate-450 mt-1 block">Placed on: {{ $order->created_at->format('d M Y, h:i A') }}</span>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 flex items-center space-x-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Orders</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left 2 Columns: Items & Address -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Ordered Items Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6">
                <h4 class="font-serif font-bold text-slate-800 text-base mb-4 pb-2 border-b border-slate-50">Line Items</h4>
                <div class="divide-y divide-slate-100">
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between py-4 first:pt-0 last:pb-0">
                            <div class="flex items-center space-x-4">
                                @php
                                    $product = $item->product;
                                    $images = $product ? json_decode($product->images) : null;
                                    $image = ($images && count($images) > 0) ? asset($images[0]) : asset('images/premium_dhoop_product.png');
                                @endphp
                                <img src="{{ $image }}" alt="{{ $item->product_name }}" class="h-14 w-14 rounded-xl object-contain bg-slate-50 border border-slate-100 p-1 flex-shrink-0">
                                <div>
                                    <span class="block font-semibold text-slate-800">{{ $item->product_name }}</span>
                                    <span class="block text-xs text-slate-400 mt-1">Quantity: {{ $item->quantity }} @ ₹{{ number_format($item->unit_price, 2) }}</span>
                                </div>
                            </div>
                            <span class="font-bold text-slate-900">₹{{ number_format($item->total_price, 2) }}</span>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center">
                    <span class="text-sm font-semibold text-slate-500">Order Total</span>
                    <span class="text-lg font-bold text-slate-950">₹{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <!-- Shipping Information Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6">
                <h4 class="font-serif font-bold text-slate-800 text-base mb-4 pb-2 border-b border-slate-50">Shipping Details</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-slate-650">
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Recipient Name</span>
                        <span class="block font-semibold text-slate-800 mt-1">{{ $order->shipping_name }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Contact Number</span>
                        <span class="block font-semibold text-slate-800 mt-1">{{ $order->shipping_phone }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Email Address</span>
                        <span class="block font-semibold text-slate-800 mt-1">{{ $order->shipping_email }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Delivery Address</span>
                        <span class="block font-semibold text-slate-800 mt-1 leading-relaxed">
                            {{ $order->shipping_address }},<br>
                            {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zip }}
                        </span>
                    </div>
                </div>
                @if($order->notes)
                    <div class="mt-6 p-4 bg-slate-50 border border-slate-100 rounded-xl text-xs leading-relaxed text-slate-500">
                        <span class="font-bold text-slate-600 block mb-1">Customer Order Notes:</span>
                        "{{ $order->notes }}"
                    </div>
                @endif
            </div>

        </div>

        <!-- Right 1 Column: Manage Status -->
        <div class="space-y-6">
            
            <!-- Update Order Status Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6">
                <h4 class="font-serif font-bold text-slate-800 text-base mb-4 pb-2 border-b border-slate-50">Update Status</h4>
                
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <!-- Order Status -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Order Status</label>
                        <select name="status" class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
                            <option value="pending" @selected($order->status === 'pending')>Pending</option>
                            <option value="processing" @selected($order->status === 'processing')>Processing</option>
                            <option value="completed" @selected($order->status === 'completed')>Completed</option>
                            <option value="cancelled" @selected($order->status === 'cancelled')>Cancelled</option>
                            <option value="failed" @selected($order->status === 'failed')>Failed</option>
                        </select>
                    </div>

                    <!-- Payment Status -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Payment Status</label>
                        <select name="payment_status" class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
                            <option value="pending" @selected($order->payment_status === 'pending')>Pending</option>
                            <option value="completed" @selected($order->payment_status === 'completed')>Paid (Completed)</option>
                            <option value="failed" @selected($order->payment_status === 'failed')>Failed</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm py-3 rounded-xl transition cursor-pointer shadow-md shadow-[#C49A6C]/25">
                        Update Details
                    </button>
                </form>
            </div>

            <!-- Shiprocket Shipping Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6 text-sm text-slate-650 space-y-4">
                <h4 class="font-serif font-bold text-slate-800 text-base pb-2 border-b border-slate-50 flex items-center justify-between">
                    <span>Shiprocket Delivery</span>
                    <i class="fa-solid fa-truck-fast text-[#C49A6C]"></i>
                </h4>

                @if($order->shiprocket_order_id)
                    <div class="space-y-3">
                        <div>
                            <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Shiprocket Order ID</span>
                            <span class="block font-semibold text-slate-800 mt-0.5 font-mono text-xs">{{ $order->shiprocket_order_id }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Shipment ID</span>
                            <span class="block font-semibold text-slate-800 mt-0.5 font-mono text-xs">{{ $order->shiprocket_shipment_id }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">AWB / Tracking Code</span>
                            <span class="block font-semibold text-slate-800 mt-0.5 font-mono text-xs">{{ $order->shiprocket_awb_code ?: 'Pending Assignment' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Shiprocket Status</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#C49A6C]/10 text-[#C49A6C] mt-1">{{ $order->shiprocket_status }}</span>
                        </div>
                        
                        @if($order->shiprocket_awb_code)
                            <div class="pt-2">
                                <a href="https://shiprocket.co/tracking/{{ $order->shiprocket_awb_code }}" target="_blank" 
                                   class="w-full text-center block bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs py-2.5 rounded-xl transition">
                                    Track on Shiprocket
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="space-y-3">
                        <p class="text-xs text-slate-450 leading-relaxed">This order has not been pushed to Shiprocket yet. Click below to register this order for dispatch.</p>
                        
                        <form method="POST" action="{{ route('admin.orders.shiprocket', $order->id) }}">
                            @csrf
                            <button type="submit" class="w-full bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm py-3 rounded-xl transition cursor-pointer shadow-md shadow-[#C49A6C]/25 flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                                <span>Send to Shiprocket</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Transaction Information Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6 text-sm text-slate-650 space-y-4">
                <h4 class="font-serif font-bold text-slate-800 text-base pb-2 border-b border-slate-50">Payment Info</h4>
                
                <div>
                    <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Method</span>
                    <span class="block font-semibold text-slate-800 mt-1 uppercase">{{ $order->payment_method }}</span>
                </div>

                @if($order->payment_method === 'razorpay')
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Razorpay Order ID</span>
                        <span class="block font-semibold text-slate-800 mt-1 font-mono text-xs select-all">{{ $order->razorpay_order_id ?: 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Razorpay Payment ID</span>
                        <span class="block font-semibold text-slate-800 mt-1 font-mono text-xs select-all">{{ $order->razorpay_payment_id ?: 'N/A' }}</span>
                    </div>
                @else
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">COD Information</span>
                        <span class="block text-slate-500 mt-1 leading-relaxed">Collect cash upon delivery. Collect exactly ₹{{ number_format($order->total_amount, 2) }}.</span>
                    </div>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection
