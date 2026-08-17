@extends('layouts.admin')

@section('header_title', 'Create Product Review')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-xs">
    
    <div class="mb-6 flex items-center justify-between">
        <h3 class="font-serif font-bold text-slate-800 text-lg">Add New Product Review</h3>
        <a href="{{ route('admin.reviews.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 flex items-center space-x-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Reviews</span>
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-xl text-rose-800 text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.reviews.store') }}" class="space-y-6">
        @csrf

        <!-- Product Selection -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Product *</label>
            <select name="product_id" required class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
                <option value="" disabled @selected(!old('product_id') && !$selectedProductId)>Choose a Product...</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" @selected(old('product_id', $selectedProductId) == $product->id)>
                        {{ $product->name }} (SKU: {{ $product->sku }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Reviewer Name -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Reviewer Name *</label>
                <input type="text" name="reviewer_name" value="{{ old('reviewer_name') }}" required placeholder="e.g. Ramesh Kumar"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
            </div>

            <!-- Reviewer Email -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Reviewer Email (Optional)</label>
                <input type="email" name="reviewer_email" value="{{ old('reviewer_email') }}" placeholder="e.g. ramesh@example.com"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Rating -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Rating Star *</label>
                <select name="rating" required class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
                    <option value="5" @selected(old('rating') == 5 || !old('rating'))>5 Stars</option>
                    <option value="4" @selected(old('rating') == 4)>4 Stars</option>
                    <option value="3" @selected(old('rating') == 3)>3 Stars</option>
                    <option value="2" @selected(old('rating') == 2)>2 Stars</option>
                    <option value="1" @selected(old('rating') == 1)>1 Star</option>
                </select>
            </div>

            <!-- Status -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Status</label>
                <label class="flex items-center space-x-3 cursor-pointer border border-slate-200 rounded-xl px-4 py-2.5 bg-white h-[45px]">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))
                           class="rounded border-slate-350 text-[#C49A6C] focus:ring-[#C49A6C] h-4.5 w-4.5">
                    <span class="text-sm font-semibold text-slate-700">Active (Visible on frontend)</span>
                </label>
            </div>
        </div>

        <!-- Review Content -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Review Content *</label>
            <textarea name="review" rows="4" required placeholder="Type product review details here..."
                      class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">{{ old('review') }}</textarea>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.reviews.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-250 text-slate-500 font-semibold text-sm hover:bg-slate-50 transition">
                Cancel
            </a>
            <button type="submit" class="bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md shadow-[#C49A6C]/20 transition cursor-pointer">
                Save Review
            </button>
        </div>
    </form>

</div>
@endsection
