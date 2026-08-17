@extends('layouts.admin')

@section('header_title', 'Manage Product Reviews')

@section('content')
<div class="space-y-6">

    <!-- Actions Panel -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-5 rounded-2xl border border-slate-100 shadow-xs">
        <!-- Search & Filter Form -->
        <form method="GET" action="{{ route('admin.reviews.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search reviewer, review, product..." 
                   class="w-full sm:w-64 border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-slate-50">
            
            <select name="product_id" class="w-full sm:w-56 border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-slate-50">
                <option value="">All Products</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" @selected(request('product_id') == $product->id)>{{ $product->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition cursor-pointer">
                Filter
            </button>
            
            @if(request()->anyFilled(['search', 'product_id']))
                <a href="{{ route('admin.reviews.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600">Clear</a>
            @endif
        </form>

        <!-- Create Button -->
        <a href="{{ route('admin.reviews.create', ['product_id' => request('product_id')]) }}" class="w-full sm:w-auto text-center bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm px-6 py-3 rounded-xl shadow-md shadow-[#C49A6C]/25 transition cursor-pointer flex items-center justify-center space-x-2">
            <i class="fa-solid fa-plus"></i>
            <span>Add Review</span>
        </a>
    </div>

    <!-- Reviews Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-55 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">Reviewer</th>
                        <th class="px-6 py-4">Rating</th>
                        <th class="px-6 py-4">Review</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-650">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                @if($review->product)
                                    <a href="{{ route('admin.products.edit', $review->product->id) }}" class="font-semibold text-[#C49A6C] hover:underline block max-w-xs truncate" title="{{ $review->product->name }}">
                                        {{ $review->product->name }}
                                    </a>
                                    <span class="text-xs text-slate-400 mt-0.5">SKU: {{ $review->product->sku }}</span>
                                @else
                                    <span class="text-slate-400 italic">Deleted Product</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="block font-semibold text-slate-800">{{ $review->reviewer_name }}</span>
                                @if($review->reviewer_email)
                                    <span class="block text-xs text-slate-400 mt-0.5">{{ $review->reviewer_email }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-yellow-500 font-semibold text-xs whitespace-nowrap">
                                @for($i=1; $i<=5; $i++)
                                    <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                @endfor
                            </td>
                            <td class="px-6 py-4 text-slate-500 max-w-sm truncate" title="{{ $review->review }}">
                                "{{ $review->review }}"
                            </td>
                            <td class="px-6 py-4">
                                @if($review->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center space-x-2">
                                    <a href="{{ route('admin.reviews.edit', $review->id) }}" class="p-2 bg-slate-100 hover:bg-[#C49A6C] hover:text-white rounded-lg text-slate-600 transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-slate-100 hover:bg-red-500 hover:text-white rounded-lg text-slate-600 transition cursor-pointer" title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-medium">No reviews found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($reviews->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
