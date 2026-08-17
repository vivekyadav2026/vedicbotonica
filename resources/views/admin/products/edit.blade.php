@extends('layouts.admin')

@section('header_title', 'Edit Product')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-xs">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h3 class="font-serif font-bold text-slate-800 text-lg">Edit: {{ $product->name }}</h3>
            <span class="text-xs text-slate-450 mt-1 block">Last updated: {{ $product->updated_at->format('d M Y, h:i A') }}</span>
        </div>
        <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 flex items-center space-x-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Products</span>
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

    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Product Name -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Product Name *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required placeholder="e.g. VEDIC JASMINE Gou Dhoop sticks"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
            </div>

            <!-- Category -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Category *</label>
                <select name="category_id" required class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Price -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Regular Price (₹) *</label>
                <input type="number" name="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" required placeholder="e.g. 250.00"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
            </div>

            <!-- Sale Price -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Sale Price (₹) (Optional)</label>
                <input type="number" name="sale_price" step="0.01" min="0" value="{{ old('sale_price', $product->sale_price) }}" placeholder="e.g. 199.00"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
            </div>

            <!-- SKU -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">SKU (Optional)</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" placeholder="Leave blank to auto-generate"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
            </div>

            <!-- Stock Quantity -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Stock Quantity *</label>
                <input type="number" name="quantity" min="0" value="{{ old('quantity', $product->quantity) }}" required placeholder="e.g. 100"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
            </div>
        </div>

        <!-- Short Description -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Short Description</label>
            <textarea name="short_description" rows="2" placeholder="Brief tagline or features list..."
                      class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">{{ old('short_description', $product->short_description) }}</textarea>
        </div>

        <!-- Long Description -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Detailed Description</label>
            <textarea name="description" rows="5" placeholder="Detailed benefits, ingredient composition, how to use..."
                      class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Checkbox Switches -->
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 grid grid-cols-2 md:grid-cols-4 gap-4">
            <label class="flex items-center space-x-3 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))
                       class="rounded border-slate-350 text-[#C49A6C] focus:ring-[#C49A6C] h-4.5 w-4.5">
                <span class="text-sm font-semibold text-slate-700">Featured</span>
            </label>

            <label class="flex items-center space-x-3 cursor-pointer">
                <input type="checkbox" name="is_bestseller" value="1" @checked(old('is_bestseller', $product->is_bestseller))
                       class="rounded border-slate-350 text-[#C49A6C] focus:ring-[#C49A6C] h-4.5 w-4.5">
                <span class="text-sm font-semibold text-slate-700">Bestseller</span>
            </label>

            <label class="flex items-center space-x-3 cursor-pointer">
                <input type="checkbox" name="deal_of_week" value="1" @checked(old('deal_of_week', $product->deal_of_week))
                       class="rounded border-slate-350 text-[#C49A6C] focus:ring-[#C49A6C] h-4.5 w-4.5">
                <span class="text-sm font-semibold text-slate-700">Deal of Week</span>
            </label>

            <label class="flex items-center space-x-3 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active))
                       class="rounded border-slate-350 text-[#C49A6C] focus:ring-[#C49A6C] h-4.5 w-4.5">
                <span class="text-sm font-semibold text-slate-700">Publish Active</span>
            </label>
        </div>

        <!-- Current Images Gallery -->
        @php
            $currentImages = json_decode($product->images, true) ?? [];
        @endphp
        @if(count($currentImages) > 0)
            <div class="space-y-3">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Current Images (Select to Delete)</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach($currentImages as $img)
                        <div class="relative bg-slate-50 border border-slate-100 rounded-xl p-2 flex flex-col items-center">
                            <img src="{{ asset($img) }}" class="h-20 w-full object-contain mb-2 rounded-lg">
                            <label class="inline-flex items-center space-x-1.5 cursor-pointer text-xs font-semibold text-rose-600 hover:text-rose-800">
                                <input type="checkbox" name="remove_images[]" value="{{ $img }}" class="rounded text-rose-600 border-slate-300 focus:ring-rose-500">
                                <span>Remove</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Product Image Upload -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Upload New Images</label>
            <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 hover:bg-slate-50 transition relative flex flex-col items-center justify-center text-center cursor-pointer">
                <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-300 mb-3"></i>
                <span class="text-sm font-semibold text-slate-700">Select images to upload</span>
                <span class="text-xs text-slate-400 mt-1 block">PNG, JPG, JPEG, WEBP files up to 2MB each</span>
                <input type="file" name="images[]" multiple accept="image/*"
                       class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
            </div>
        </div>

        <!-- Shipping / Dimensions for Shiprocket -->
        <div class="bg-amber-50 border border-amber-100 p-5 rounded-2xl space-y-4">
            <div class="flex items-center space-x-2 pb-1.5 border-b border-amber-100">
                <i class="fa-solid fa-truck-fast text-amber-500 text-xs"></i>
                <h4 class="font-bold text-slate-700 text-sm uppercase tracking-wider">Shipping Details (for Shiprocket)</h4>
            </div>
            <span class="text-xs text-slate-400 block -mt-1">These values are sent automatically to Shiprocket when you dispatch an order.</span>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Weight (kg) *</label>
                    <input type="number" name="weight" step="0.001" min="0.001" value="{{ old('weight', $product->weight) }}" required
                           class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
                    <span class="text-[10px] text-slate-400">Packed weight</span>
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Length (cm) *</label>
                    <input type="number" name="length" min="1" value="{{ old('length', $product->length) }}" required
                           class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Width (cm) *</label>
                    <input type="number" name="width" min="1" value="{{ old('width', $product->width) }}" required
                           class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Height (cm) *</label>
                    <input type="number" name="height" min="1" value="{{ old('height', $product->height) }}" required
                           class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
                </div>
            </div>

            <div class="pt-2">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Quick Presets:</span>
                <div class="flex flex-wrap gap-2 mt-2">
                    <button type="button" onclick="setDimensions(0.165, 14, 5, 5)" class="text-xs px-3 py-1.5 rounded-lg bg-white border border-amber-200 text-amber-700 hover:bg-amber-50 transition cursor-pointer font-medium">PET Box Cones (165g)</button>
                    <button type="button" onclick="setDimensions(0.161, 14, 5, 5)" class="text-xs px-3 py-1.5 rounded-lg bg-white border border-amber-200 text-amber-700 hover:bg-amber-50 transition cursor-pointer font-medium">PET Box Sticks (161g)</button>
                    <button type="button" onclick="setDimensions(0.141, 16, 8, 6)" class="text-xs px-3 py-1.5 rounded-lg bg-white border border-amber-200 text-amber-700 hover:bg-amber-50 transition cursor-pointer font-medium">Corrugated Cones (141g)</button>
                    <button type="button" onclick="setDimensions(0.147, 16, 8, 6)" class="text-xs px-3 py-1.5 rounded-lg bg-white border border-amber-200 text-amber-700 hover:bg-amber-50 transition cursor-pointer font-medium">Corrugated Sticks (147g)</button>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-250 text-slate-500 font-semibold text-sm hover:bg-slate-50 transition">
                Cancel
            </a>
            <button type="submit" class="bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md shadow-[#C49A6C]/20 transition cursor-pointer">
                Update Product
            </button>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
function setDimensions(weight, length, width, height) {
    document.querySelector('input[name="weight"]').value = weight;
    document.querySelector('input[name="length"]').value = length;
    document.querySelector('input[name="width"]').value = width;
    document.querySelector('input[name="height"]').value = height;
}
</script>
@endpush
