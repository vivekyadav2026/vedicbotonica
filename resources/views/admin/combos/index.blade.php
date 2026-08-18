@extends('layouts.admin')

@section('header_title', 'Manage Combo Packs')

@section('content')
<div class="space-y-6">

    <!-- Actions Panel -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-5 rounded-2xl border border-slate-100 shadow-xs">
        <!-- Search & Filter Form -->
        <form method="GET" action="{{ route('admin.combos.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by combo name, SKU..." 
                   class="w-full sm:w-64 border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-slate-50">
            
            <select name="category_id" class="w-full sm:w-48 border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-slate-50">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition cursor-pointer">
                Filter
            </button>
            
            @if(request()->anyFilled(['search', 'category_id']))
                <a href="{{ route('admin.combos.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600">Clear</a>
            @endif
        </form>

        <!-- Create Button -->
        <a href="{{ route('admin.combos.create') }}" class="w-full sm:w-auto text-center bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm px-6 py-3 rounded-xl shadow-md shadow-[#C49A6C]/25 transition cursor-pointer flex items-center justify-center space-x-2">
            <i class="fa-solid fa-plus"></i>
            <span>Add Combo Pack</span>
        </a>
    </div>

    <!-- Combos Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-55 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Image</th>
                        <th class="px-6 py-4">Combo Name / SKU</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Selling Price</th>
                        <th class="px-6 py-4">Combined Stock</th>
                        <th class="px-6 py-4">Individual Value</th>
                        <th class="px-6 py-4">Badges</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-650">
                    @forelse($combos as $product)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                @php
                                    $images = json_decode($product->images);
                                    $image = ($images && count($images) > 0) ? asset($images[0]) : asset('images/premium_dhoop_product.png');
                                @endphp
                                <img src="{{ $image }}" alt="{{ $product->name }}" class="h-12 w-12 rounded-xl object-contain bg-slate-50 border border-slate-100 p-1">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <span class="block font-semibold text-slate-800 max-w-xs truncate" title="{{ $product->name }}">{{ $product->name }}</span>
                                </div>
                                <span class="block text-xs text-slate-400 mt-0.5">SKU: {{ $product->sku ?: 'N/A' }}</span>

                                <!-- List child items recipe -->
                                <div class="mt-2.5 flex flex-wrap gap-x-2 gap-y-1 text-[10px] text-slate-400 font-medium">
                                    <span class="text-slate-450 self-center">Contains:</span>
                                    @foreach($product->comboItems as $item)
                                        @if($item->product)
                                            <span class="bg-slate-50 border border-slate-100 px-1.5 py-0.5 rounded text-slate-650 font-sans">
                                                {{ $item->product->name }} (×{{ $item->quantity }})
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-600">{{ $product->category->name }}</td>
                            <td class="px-6 py-4">
                                @if($product->sale_price)
                                    <span class="block font-bold text-slate-900">₹{{ number_format($product->sale_price, 2) }}</span>
                                    <span class="block text-xs text-slate-400 line-through">₹{{ number_format($product->price, 2) }}</span>
                                @else
                                    <span class="font-bold text-slate-900">₹{{ number_format($product->price, 2) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold {{ $product->quantity <= 5 ? 'text-red-500 font-bold' : 'text-slate-700' }}">
                                    {{ $product->quantity }} packs available
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs font-sans">
                                    <span class="block font-medium text-slate-500">Value: ₹{{ number_format($product->individual_value, 2) }}</span>
                                    @if($product->savings > 0)
                                        <span class="block font-semibold text-emerald-600">Save ₹{{ number_format($product->savings, 2) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @if($product->is_featured)
                                        <span class="px-1.5 py-0.5 text-[9px] font-bold bg-amber-50 text-amber-700 rounded border border-amber-100">Featured</span>
                                    @endif
                                    @if($product->is_bestseller)
                                        <span class="px-1.5 py-0.5 text-[9px] font-bold bg-purple-50 text-purple-700 rounded border border-purple-100">Bestseller</span>
                                    @endif
                                    @if($product->deal_of_week)
                                        <span class="px-1.5 py-0.5 text-[9px] font-bold bg-blue-50 text-blue-700 rounded border border-blue-100">Deal</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($product->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center space-x-2">
                                    <a href="{{ route('admin.combos.edit', $product->id) }}" class="p-2 bg-slate-100 hover:bg-[#C49A6C] hover:text-white rounded-lg text-slate-650 transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.combos.destroy', $product->id) }}" onsubmit="return confirm('Are you sure you want to delete this combo pack?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-slate-100 hover:bg-red-500 hover:text-white rounded-lg text-slate-650 transition cursor-pointer" title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-slate-400 font-medium">No combo packs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($combos->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $combos->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
