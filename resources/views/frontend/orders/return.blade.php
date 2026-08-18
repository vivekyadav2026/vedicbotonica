@extends('layouts.frontend')

@section('title', 'Request Product Return')

@section('content')
    <!-- Page Header -->
    <div class="bg-[#fdfaf6] py-5 md:py-12 text-center border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[10px] md:text-sm text-gray-500 uppercase tracking-widest leading-relaxed">
                <a href="/" class="hover:text-[#C49A6C] transition">Home</a> / 
                <a href="{{ route('dashboard') }}" class="hover:text-[#C49A6C] transition">Dashboard</a> / 
                <span class="text-gray-900 font-medium">Return Order</span>
            </p>
            <h1 class="text-2xl sm:text-4xl font-serif font-bold text-gray-900 mt-1 md:mt-2">Request Product Return</h1>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-16">
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm flex items-center space-x-3">
                <i class="fa-solid fa-circle-exclamation text-base flex-shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white border border-[#C49A6C]/20 rounded-3xl shadow-sm p-6 sm:p-10">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center border-b border-gray-150 pb-6 mb-8 gap-4">
                <div>
                    <h3 class="text-lg font-serif font-bold text-gray-900">Order Information</h3>
                    <p class="text-sm font-mono text-gray-550 mt-1">#{{ $order->order_number }}</p>
                </div>
                <div class="text-left sm:text-right">
                    <span class="text-xs text-gray-400 block">Ordered On</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $order->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            <form action="{{ route('orders.return.store', $order->id) }}" method="POST">
                @csrf

                <!-- Section: Select Items -->
                <div class="mb-8">
                    <h3 class="text-md font-serif font-bold text-gray-900 mb-4 flex items-center">
                        <span class="bg-[#C49A6C]/10 text-[#C49A6C] h-7 w-7 rounded-full flex items-center justify-center text-xs font-semibold mr-2.5">1</span>
                        Select Items to Return
                    </h3>
                    <p class="text-xs text-gray-500 mb-6">Choose the products and quantities you wish to return from this order.</p>

                    <div class="border border-gray-100 rounded-2xl divide-y divide-gray-100 overflow-hidden shadow-xs bg-gray-50/30">
                        @foreach($order->items as $item)
                            <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 transition-colors hover:bg-white/60">
                                <div class="flex items-center space-x-4">
                                    <!-- Selection Checkbox -->
                                    <label class="relative flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               name="items[{{ $item->id }}][selected]" 
                                               value="1" 
                                               class="peer sr-only"
                                               {{ old("items.{$item->id}.selected") ? 'checked' : '' }}
                                               onchange="toggleItemInputs(this, {{ $item->id }})">
                                        <div class="h-6 w-6 rounded-md border border-gray-300 bg-white flex items-center justify-center transition-all peer-checked:bg-[#C49A6C] peer-checked:border-[#C49A6C] peer-focus:ring-2 peer-focus:ring-[#C49A6C]/30">
                                            <i class="fa-solid fa-check text-white text-xs opacity-0 transition-opacity peer-checked:opacity-100"></i>
                                        </div>
                                    </label>

                                    <!-- Product Image placeholder / icon -->
                                    <div class="h-12 w-12 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-400 shadow-sm flex-shrink-0">
                                        @if($item->product && $item->product->images && count(json_decode($item->product->images, true) ?? []) > 0)
                                            <img src="{{ asset(json_decode($item->product->images, true)[0]) }}" alt="{{ $item->product_name }}" class="h-full w-full object-cover rounded-xl">
                                        @else
                                            <i class="fa-solid fa-box text-lg"></i>
                                        @endif
                                    </div>

                                    <!-- Product Details -->
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-sm sm:text-base leading-tight">{{ $item->product_name }}</h4>
                                        <span class="text-xs text-[#C49A6C] font-semibold mt-1 block">₹{{ number_format($item->unit_price, 2) }}</span>
                                    </div>
                                </div>

                                <!-- Quantity selection dropdown -->
                                <div class="w-full sm:w-auto flex items-center justify-between sm:justify-start space-x-3 pl-10 sm:pl-0">
                                    <span class="text-xs text-gray-400">Return Quantity:</span>
                                    <select name="items[{{ $item->id }}][quantity]" 
                                            id="qty-select-{{ $item->id }}"
                                            class="border border-gray-200 rounded-xl px-3 py-1.5 text-sm font-semibold bg-white focus:outline-none focus:border-[#C49A6C] disabled:bg-gray-100 disabled:text-gray-400"
                                            {{ old("items.{$item->id}.selected") ? '' : 'disabled' }}>
                                        @for($i = 1; $i <= $item->quantity; $i++)
                                            <option value="{{ $i }}" {{ old("items.{$item->id}.quantity") == $i ? 'selected' : '' }}>{{ $i }} of {{ $item->quantity }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Section: Reason for Return -->
                <div class="mb-10">
                    <h3 class="text-md font-serif font-bold text-gray-900 mb-4 flex items-center">
                        <span class="bg-[#C49A6C]/10 text-[#C49A6C] h-7 w-7 rounded-full flex items-center justify-center text-xs font-semibold mr-2.5">2</span>
                        Reason for Return
                    </h3>
                    <p class="text-xs text-gray-500 mb-4">Please describe why you are requesting a return so our quality assurance team can address it.</p>
                    
                    <textarea name="reason" 
                              rows="5" 
                              placeholder="Describe the reason for return in detail (e.g. Received damaged packaging, defective item, incorrect item delivered...)"
                              class="w-full border border-gray-200 rounded-2xl p-4 text-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/50 shadow-xs" 
                              required>{{ old('reason') }}</textarea>
                </div>

                <!-- Action buttons -->
                <div class="flex flex-col sm:flex-row sm:justify-end gap-3 pt-6 border-t border-gray-150">
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-500 text-center hover:bg-gray-50 transition cursor-pointer">Cancel</a>
                    <button type="submit" class="px-8 py-3 rounded-xl bg-[#C49A6C] hover:bg-[#b08759] text-white text-sm font-bold text-center transition cursor-pointer shadow-md shadow-[#C49A6C]/10">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleItemInputs(checkbox, itemId) {
            const selectEl = document.getElementById('qty-select-' + itemId);
            if (selectEl) {
                selectEl.disabled = !checkbox.checked;
            }
        }
    </script>
@endsection
