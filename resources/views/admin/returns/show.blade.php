@extends('layouts.admin')

@section('header_title', 'Return Request Details')

@section('content')
<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="font-serif font-bold text-slate-800 text-lg">Return Request: #{{ $returnRequest->id }}</h3>
            <span class="text-xs text-slate-450 mt-1 block">Requested on: {{ $returnRequest->created_at->format('d M Y, h:i A') }}</span>
        </div>
        <a href="{{ route('admin.returns.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 flex items-center space-x-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Return Requests</span>
        </a>
    </div>

    <!-- Error/Success Alerts -->
    @if(session('error'))
        <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl text-rose-700 text-sm">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left 2 Columns: Returned Items & Reason -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Returned Items Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6">
                <h4 class="font-serif font-bold text-slate-800 text-base mb-4 pb-2 border-b border-slate-50">Items to Return</h4>
                <div class="divide-y divide-slate-100">
                    @foreach($returnRequest->items as $item)
                        @php
                            $orderItem = $item->orderItem;
                        @endphp
                        @if($orderItem)
                            <div class="flex items-start justify-between py-4 first:pt-0 last:pb-0">
                                <div class="flex items-start space-x-4">
                                    @php
                                        $product = $orderItem->product;
                                        $images = $product ? json_decode($product->images) : null;
                                        $image = ($images && count($images) > 0) ? asset($images[0]) : asset('images/premium_dhoop_product.png');
                                    @endphp
                                    <img src="{{ $image }}" alt="{{ $orderItem->product_name }}" class="h-14 w-14 rounded-xl object-contain bg-slate-50 border border-slate-100 p-1 flex-shrink-0 mt-1">
                                    <div>
                                        <span class="block font-semibold text-slate-800">{{ $orderItem->product_name }}</span>
                                        <span class="block text-xs text-slate-450 mt-1">
                                            Return Qty: <strong class="text-slate-800 text-sm">{{ $item->quantity }}</strong> (Ordered: {{ $orderItem->quantity }})
                                        </span>
                                        <span class="block text-xs text-[#C49A6C] font-semibold mt-1">Unit Price: ₹{{ number_format($orderItem->unit_price, 2) }}</span>
                                        
                                        @if($orderItem->components->isNotEmpty())
                                            <!-- Snapshot child items nested display -->
                                            <div class="mt-2.5 space-y-1 bg-slate-50 border border-slate-100 rounded-lg p-2.5 max-w-md">
                                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Recipe Snapshot:</span>
                                                @foreach($orderItem->components as $component)
                                                    <div class="flex items-center justify-between text-xs text-slate-600 font-sans">
                                                        <span class="truncate pr-4">{{ $component->product_name }}</span>
                                                        <span class="font-bold text-slate-400">
                                                            Restocking: {{ ($component->quantity / $orderItem->quantity) * $item->quantity }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <span class="font-bold text-slate-900">₹{{ number_format($orderItem->unit_price * $item->quantity, 2) }}</span>
                            </div>
                        @else
                            <div class="py-4 text-xs text-slate-400">Order item has been removed from database.</div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Return Reason Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6">
                <h4 class="font-serif font-bold text-slate-800 text-base mb-3 pb-2 border-b border-slate-50">Customer Reason for Return</h4>
                <div class="text-slate-650 text-sm leading-relaxed whitespace-pre-line bg-slate-50/50 border border-slate-100 rounded-2xl p-4 font-sans">
                    {{ $returnRequest->reason }}
                </div>
            </div>

            <!-- Customer Details Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6">
                <h4 class="font-serif font-bold text-slate-800 text-base mb-4 pb-2 border-b border-slate-50">Customer & Original Order Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-slate-600 font-sans">
                    <div class="space-y-2">
                        <h5 class="text-xs text-slate-400 uppercase font-bold tracking-wider">Customer Details</h5>
                        <p><strong class="text-slate-800">Name:</strong> {{ $returnRequest->user->name }}</p>
                        <p><strong class="text-slate-800">Email:</strong> {{ $returnRequest->user->email }}</p>
                        <p><strong class="text-slate-800">Phone:</strong> {{ $returnRequest->user->phone ?: 'N/A' }}</p>
                    </div>
                    <div class="space-y-2">
                        <h5 class="text-xs text-slate-400 uppercase font-bold tracking-wider">Original Order Details</h5>
                        @if($returnRequest->order)
                            <p><strong class="text-slate-800">Order Number:</strong> {{ $returnRequest->order->order_number }}</p>
                            <p><strong class="text-slate-800">Order Status:</strong> <span class="capitalize">{{ $returnRequest->order->status }}</span></p>
                            <p><strong class="text-slate-800">Total Order Amount:</strong> ₹{{ number_format($returnRequest->order->total_amount, 2) }}</p>
                        @else
                            <p class="text-red-500 font-bold">Order Record Missing/Deleted</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Decision Actions -->
        <div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6 space-y-6">
                <div>
                    <h4 class="font-serif font-bold text-slate-800 text-base">Request Status</h4>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold mt-2
                        {{ $returnRequest->status === 'pending' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' }}
                        {{ $returnRequest->status === 'approved' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' }}
                        {{ $returnRequest->status === 'rejected' ? 'bg-rose-50 text-rose-700 border border-rose-200' : '' }}
                    ">
                        {{ ucfirst($returnRequest->status) }}
                    </span>
                </div>

                @if($returnRequest->status === 'pending')
                    <form action="{{ route('admin.returns.updateStatus', $returnRequest->id) }}" method="POST" class="space-y-4 pt-4 border-t border-slate-50">
                        @csrf
                        <div class="space-y-1.5">
                            <label class="text-xs text-slate-550 font-bold font-sans uppercase tracking-wider block">Decision Notes (Admin Notes)</label>
                            <textarea name="admin_notes" rows="4" placeholder="Optional comments regarding approval or rejection..." class="w-full text-sm border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/30 shadow-xs bg-slate-50/20"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <button type="submit" name="status" value="rejected" class="bg-rose-50 border border-rose-200 text-rose-700 hover:bg-rose-600 hover:text-white font-bold py-3 px-4 rounded-xl text-xs tracking-wider transition cursor-pointer text-center focus:outline-none">
                                Reject Request
                            </button>
                            <button type="submit" name="status" value="approved" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-xl text-xs tracking-wider transition cursor-pointer text-center focus:outline-none shadow-md shadow-emerald-600/10" onclick="return confirm('Approving this return request will automatically restock standard items and child components of Combo items. Proceed?')">
                                Approve & Restock
                            </button>
                        </div>
                    </form>
                @else
                    <div class="pt-4 border-t border-slate-50 space-y-3 font-sans text-sm">
                        <div>
                            <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Processed By Admin</span>
                            <span class="text-slate-800 font-medium block mt-0.5">{{ $returnRequest->updated_at->format('d M Y, h:i A') }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Admin Decision Notes</span>
                            <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl mt-1 text-slate-650 text-xs leading-relaxed italic">
                                {{ $returnRequest->admin_notes ?: 'No comments left.' }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection
