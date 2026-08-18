@extends('layouts.frontend')

@section('title', 'My Dashboard')

@section('content')
    <!-- Page Header -->
    <div class="bg-[#fdfaf6] py-5 md:py-12 text-center border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[10px] md:text-sm text-gray-500 uppercase tracking-widest leading-relaxed">
                <a href="/" class="hover:text-primary transition">Home</a> / 
                <span class="text-gray-900 font-medium">Dashboard</span>
            </p>
            <h1 class="text-2xl sm:text-4xl font-serif font-bold text-gray-900 mt-1 md:mt-2">My Account</h1>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-16" x-data="{ activeTab: 'dashboard' }">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
            
            <!-- Sidebar Navigation (Desktop only) -->
            <div class="hidden lg:block w-full lg:w-1/4">
                <div class="bg-[#fdfaf6] border border-gray-200 rounded-xl p-6 space-y-2">
                    <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-gray-250">
                        <div class="bg-[#C49A6C]/10 text-[#C49A6C] h-12 w-12 rounded-full flex items-center justify-center font-bold text-lg font-serif">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-serif font-bold text-gray-955 text-base leading-tight">{{ Auth::user()->name }}</h4>
                            <span class="text-xs text-gray-400 font-medium">Customer Account</span>
                        </div>
                    </div>
                    
                    <button @click="activeTab = 'dashboard'" :class="activeTab === 'dashboard' ? 'bg-[#C49A6C] text-white' : 'text-gray-700 hover:bg-gray-55'" class="w-full text-left px-4 py-3 rounded-lg text-sm font-semibold transition-colors duration-250 flex items-center" style="font-family: 'Inter', sans-serif; cursor: pointer;">
                        <i class="fa-solid fa-chart-line mr-3 text-base"></i> Dashboard Overview
                    </button>
                    
                    <button @click="activeTab = 'orders'" :class="activeTab === 'orders' ? 'bg-[#C49A6C] text-white' : 'text-gray-700 hover:bg-gray-55'" class="w-full text-left px-4 py-3 rounded-lg text-sm font-semibold transition-colors duration-250 flex items-center" style="font-family: 'Inter', sans-serif; cursor: pointer;">
                        <i class="fa-solid fa-box mr-3 text-base"></i> My Orders
                    </button>
                    
                    <a href="{{ route('profile.edit') }}" class="w-full text-left px-4 py-3 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-55 transition-colors duration-250 flex items-center" style="font-family: 'Inter', sans-serif;">
                        <i class="fa-solid fa-user-gear mr-3 text-base"></i> Edit Profile
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="pt-4 border-t border-gray-250">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 rounded-lg text-sm font-semibold text-red-500 hover:bg-red-50 transition-colors duration-250 flex items-center" style="font-family: 'Inter', sans-serif; cursor: pointer;">
                            <i class="fa-solid fa-arrow-right-from-bracket mr-3 text-base"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Account Shortcuts Grid (Mobile only) -->
            <div class="block lg:hidden w-full mb-6">
                <!-- User welcome panel -->
                <div class="bg-[#FAF6F0] border border-[#C49A6C]/20 rounded-2xl p-4 mb-4 flex items-center space-x-3.5 shadow-sm">
                    <div class="bg-[#C49A6C] text-white h-11 w-11 rounded-full flex items-center justify-center font-bold text-base font-serif shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-serif font-bold text-gray-950 text-sm sm:text-base leading-tight">{{ Auth::user()->name }}</h4>
                        <p class="text-[10px] text-gray-500 font-sans mt-0.5">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <!-- 2x2 Grid of Actions -->
                <div class="grid grid-cols-2 gap-3">
                    <button @click="activeTab = 'dashboard'" :class="activeTab === 'dashboard' ? 'border-[#C49A6C] ring-1 ring-[#C49A6C] bg-[#FAF6F0]' : 'border-gray-200 bg-white'" class="flex flex-col items-center justify-center p-3.5 border rounded-xl text-center transition-all shadow-sm focus:outline-none cursor-pointer">
                        <div class="bg-[#C49A6C]/10 text-primary h-8 w-8 rounded-full flex items-center justify-center text-xs mb-1.5" style="color: #C49A6C;">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-800 font-sans">Overview</span>
                    </button>

                    <button @click="activeTab = 'orders'" :class="activeTab === 'orders' ? 'border-[#C49A6C] ring-1 ring-[#C49A6C] bg-[#FAF6F0]' : 'border-gray-200 bg-white'" class="flex flex-col items-center justify-center p-3.5 border rounded-xl text-center transition-all shadow-sm focus:outline-none cursor-pointer">
                        <div class="bg-[#C49A6C]/10 text-primary h-8 w-8 rounded-full flex items-center justify-center text-xs mb-1.5" style="color: #C49A6C;">
                            <i class="fa-solid fa-box"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-800 font-sans">My Orders</span>
                    </button>

                    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center p-3.5 border border-gray-200 bg-white rounded-xl text-center transition-all shadow-sm">
                        <div class="bg-[#C49A6C]/10 text-primary h-8 w-8 rounded-full flex items-center justify-center text-xs mb-1.5" style="color: #C49A6C;">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-800 font-sans">Edit Profile</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="m-0 w-full flex">
                        @csrf
                        <button type="submit" class="w-full flex flex-col items-center justify-center p-3.5 border border-gray-200 bg-white rounded-xl text-center transition-all shadow-sm cursor-pointer">
                            <div class="bg-red-50 text-red-500 h-8 w-8 rounded-full flex items-center justify-center text-xs mb-1.5">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </div>
                            <span class="text-xs font-bold text-red-500 font-sans">Log Out</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Content Area -->
            <div class="w-full lg:w-3/4">
                
                <!-- Tab: Dashboard Overview -->
                <div x-show="activeTab === 'dashboard'" class="space-y-8">
                    <div class="bg-[#FAF6F0] border border-[#C49A6C]/30 rounded-2xl p-8">
                        <h2 class="text-3xl font-serif font-bold text-gray-900 mb-2">Hello, {{ Auth::user()->name }}!</h2>
                        <p class="text-gray-600 text-sm leading-relaxed max-w-xl">
                            From your account dashboard, you can easily view your recent orders, manage your shipping addresses, and edit your password and account details.
                        </p>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white border border-gray-200 rounded-xl p-6 flex items-center justify-between shadow-sm">
                            <div>
                                <span class="text-xs text-gray-400 uppercase font-semibold tracking-wider">Total Orders</span>
                                <h3 class="text-3xl font-bold font-serif text-gray-950 mt-1">{{ $orders->count() }}</h3>
                            </div>
                            <div class="bg-primary/10 text-primary h-12 w-12 rounded-full flex items-center justify-center text-xl">
                                <i class="fa-solid fa-box"></i>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-xl p-6 flex items-center justify-between shadow-sm">
                            <div>
                                <span class="text-xs text-gray-400 uppercase font-semibold tracking-wider">Items in Cart</span>
                                <h3 class="text-3xl font-bold font-serif text-gray-950 mt-1">{{ array_sum(array_column(session()->get('cart', []), 'quantity')) }}</h3>
                            </div>
                            <div class="bg-primary/10 text-primary h-12 w-12 rounded-full flex items-center justify-center text-xl">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-xl p-6 flex items-center justify-between shadow-sm">
                            <div>
                                <span class="text-xs text-gray-400 uppercase font-semibold tracking-wider">Wishlisted Items</span>
                                <h3 class="text-3xl font-bold font-serif text-gray-950 mt-1">{{ count(session()->get('wishlist', [])) }}</h3>
                            </div>
                            <div class="bg-primary/10 text-primary h-12 w-12 rounded-full flex items-center justify-center text-xl">
                                <i class="fa-solid fa-heart"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: My Orders -->
                <div x-show="activeTab === 'orders'">
                    <h2 class="text-2xl font-serif font-bold text-gray-900 mb-6">Order History</h2>
                    
                    @if($orders->count() > 0)
                        <!-- Desktop Order History Table (hidden on mobile) -->
                        <div class="hidden md:block border border-gray-200 rounded-xl overflow-hidden shadow-sm bg-white">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                                            <th class="p-6">Order Number</th>
                                            <th class="p-6">Date</th>
                                            <th class="p-6">Status</th>
                                            <th class="p-6">Total</th>
                                            <th class="p-6">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($orders as $order)
                                            <tr class="text-gray-700 align-middle">
                                                <td class="p-6 font-mono font-bold text-gray-900">{{ $order->order_number }}</td>
                                                <td class="p-6 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                                                <td class="p-6 text-sm">
                                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full 
                                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                                    ">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td class="p-6 font-bold text-gray-900">₹{{ number_format($order->total_amount, 2) }}</td>
                                                <td class="p-6 flex items-center space-x-4">
                                                    <button @click="document.getElementById('order-detail-{{ $order->id }}').classList.toggle('hidden')" class="text-primary hover:text-primary-dark transition text-sm font-semibold cursor-pointer">View Items</button>
                                                    
                                                    @php $return = $order->returnRequests->first(); @endphp
                                                    @if($order->status === 'completed')
                                                        @if(!$return && $order->created_at->diffInDays(now()) <= 15)
                                                            <a href="{{ route('orders.return.create', $order->id) }}" class="text-amber-600 hover:text-amber-800 transition text-sm font-semibold">Return Items</a>
                                                        @elseif($return)
                                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full 
                                                                {{ $return->status === 'pending' ? 'bg-blue-100 text-blue-800' : '' }}
                                                                {{ $return->status === 'approved' ? 'bg-green-105 text-green-800' : '' }}
                                                                {{ $return->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                                            ">
                                                                Return: {{ ucfirst($return->status) }}
                                                            </span>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            <!-- Nested Order Items details row -->
                                            <tr id="order-detail-{{ $order->id }}" class="hidden bg-gray-50">
                                                <td colspan="5" class="p-6">
                                                    <div class="space-y-4">
                                                        <h4 class="font-serif font-bold text-gray-900 text-sm border-b pb-2">Items in Order {{ $order->order_number }}</h4>
                                                        <div class="divide-y divide-gray-200">
                                                            @foreach($order->items as $item)
                                                                <div class="flex justify-between items-center py-3">
                                                                    <div class="flex items-center space-x-3">
                                                                        <div class="bg-white border rounded p-1 h-10 w-10 flex items-center justify-center">
                                                                            <i class="fa-solid fa-box text-gray-400"></i>
                                                                        </div>
                                                                        <div>
                                                                            <span class="font-bold text-gray-900 text-sm block leading-tight">{{ $item->product_name }}</span>
                                                                            <span class="text-xs text-gray-500">Qty: {{ $item->quantity }} @ ₹{{ number_format($item->unit_price, 2) }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="font-bold text-gray-955 text-sm">₹{{ number_format($item->total_price, 2) }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="pt-4 border-t text-sm text-gray-600 space-y-1">
                                                            <p><span class="font-semibold text-gray-900">Shipping Address:</span> {{ $order->shipping_name }}, {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zip }}</p>
                                                            <p><span class="font-semibold text-gray-900">Contact:</span> {{ $order->shipping_phone }} | {{ $order->shipping_email }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Mobile Order History Cards (hidden on desktop) -->
                        <div class="block md:hidden space-y-4">
                            @foreach($orders as $order)
                                <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                                    <div class="flex justify-between items-center mb-2.5">
                                        <span class="font-mono font-bold text-gray-900 text-sm">#{{ $order->order_number }}</span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-full 
                                            {{ $order->status === 'completed' ? 'bg-green-50 text-green-700 border border-green-200' : '' }}
                                            {{ $order->status === 'pending' ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' : '' }}
                                            {{ $order->status === 'cancelled' ? 'bg-red-50 text-red-700 border border-red-200' : '' }}
                                        ">
                                            {{ $order->status }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center text-xs text-gray-500 mb-3">
                                        <span>Date: {{ $order->created_at->format('M d, Y') }}</span>
                                        <span class="text-sm font-bold text-gray-900">Total: ₹{{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                    <div class="border-t border-gray-100 pt-2.5 flex justify-between items-center text-xs font-bold uppercase tracking-wider">
                                        <button @click="document.getElementById('order-detail-mobile-{{ $order->id }}').classList.toggle('hidden')" class="text-primary hover:text-primary-dark transition focus:outline-none flex items-center space-x-1 cursor-pointer">
                                            <span>View Items</span>
                                            <i class="fa-solid fa-chevron-down text-[9px] ml-1"></i>
                                        </button>
                                        
                                        @php $return = $order->returnRequests->first(); @endphp
                                        @if($order->status === 'completed')
                                            @if(!$return && $order->created_at->diffInDays(now()) <= 15)
                                                <a href="{{ route('orders.return.create', $order->id) }}" class="text-amber-600 hover:text-amber-800 transition">Return Items</a>
                                            @elseif($return)
                                                <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-full 
                                                    {{ $return->status === 'pending' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' }}
                                                    {{ $return->status === 'approved' ? 'bg-green-50 text-green-700 border border-green-200' : '' }}
                                                    {{ $return->status === 'rejected' ? 'bg-red-50 text-red-700 border border-red-200' : '' }}
                                                ">
                                                    Return: {{ $return->status }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                    
                                    <!-- Nested Mobile Items list -->
                                    <div id="order-detail-mobile-{{ $order->id }}" class="hidden mt-3 pt-3 border-t border-gray-150 space-y-3">
                                        <div class="divide-y divide-gray-100">
                                            @foreach($order->items as $item)
                                                <div class="flex justify-between items-center py-2.5">
                                                    <div class="flex items-center space-x-2.5">
                                                        <div class="bg-gray-50 border border-gray-100 rounded-lg h-9 w-9 flex items-center justify-center text-gray-400">
                                                            <i class="fa-solid fa-box text-xs"></i>
                                                        </div>
                                                        <div>
                                                            <span class="font-bold text-gray-900 text-xs block leading-tight">{{ $item->product_name }}</span>
                                                            <span class="text-[10px] text-gray-500">Qty: {{ $item->quantity }} @ ₹{{ number_format($item->unit_price, 2) }}</span>
                                                        </div>
                                                    </div>
                                                    <span class="font-bold text-gray-955 text-xs">₹{{ number_format($item->total_price, 2) }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="pt-2.5 border-t text-[10px] text-gray-500 space-y-1 bg-gray-50/60 p-2.5 rounded-xl border border-gray-100/50">
                                            <p><span class="font-bold text-gray-800">Address:</span> {{ $order->shipping_name }}, {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zip }}</p>
                                            <p><span class="font-bold text-gray-800">Contact:</span> {{ $order->shipping_phone }} | {{ $order->shipping_email }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-[#fdfaf6] rounded-2xl border border-dashed border-gray-300">
                            <i class="fa-solid fa-box-open text-5xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-sm font-semibold">You haven't placed any orders yet.</p>
                            <a href="/shop" class="mt-4 inline-block text-primary hover:text-primary-dark text-sm font-bold underline">Go Shop Rudrakshas</a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
