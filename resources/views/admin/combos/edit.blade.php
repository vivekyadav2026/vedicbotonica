@extends('layouts.admin')

@section('header_title', 'Edit Combo Pack')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-xs">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h3 class="font-serif font-bold text-slate-800 text-lg">Edit: {{ $product->name }}</h3>
            <span class="text-xs text-slate-450 mt-1 block">Last updated: {{ $product->updated_at->format('d M Y, h:i A') }}</span>
        </div>
        <a href="{{ route('admin.combos.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 flex items-center space-x-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Combos</span>
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

    <form method="POST" action="{{ route('admin.combos.update', $product->id) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Combo Name -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Combo Name *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required placeholder="e.g. Daily Meditation Combo Pack"
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
                <input type="number" name="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" required placeholder="e.g. 599.00"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
            </div>

            <!-- Sale Price -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Sale Price (₹) (Optional)</label>
                <input type="number" name="sale_price" step="0.01" min="0" value="{{ old('sale_price', $product->sale_price) }}" placeholder="e.g. 499.00"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5">
            </div>

            <!-- SKU -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">SKU (Optional)</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" placeholder="Leave blank to auto-generate"
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

        <!-- What's Inside This Combo? Section -->
        <div id="combo-section" class="space-y-4 bg-slate-55 p-5 rounded-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h4 class="font-serif font-bold text-slate-800 text-base">What's Inside This Combo?</h4>
                <span class="text-xs text-slate-400">Add active individual products to this recipe</span>
            </div>
            
            <!-- List of selected child products -->
            <div id="selected-products-container" class="space-y-3">
                <!-- Dynamically populated via JS -->
            </div>
            
            <!-- Product Search & Add Row -->
            <div class="flex gap-3">
                <select id="product-search-select" class="flex-1 border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
                    <option value="">-- Choose Product to Add --</option>
                    @foreach(\App\Models\Product::where('is_active', true)->where('is_combo', false)->orderBy('name')->get() as $p)
                        <option value="{{ $p->id }}" data-name="{{ $p->name }}" data-price="{{ $p->sale_price ?: $p->price }}" data-image="{{ json_decode($p->images)[0] ?? 'images/premium_dhoop_product.png' }}">
                            {{ $p->name }} (₹{{ $p->sale_price ?: $p->price }})
                        </option>
                    @endforeach
                </select>
                <button type="button" onclick="addChildProduct()" class="bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition uppercase tracking-wider cursor-pointer">
                    Add Product
                </button>
            </div>

            <!-- Live Price / Discount Calculator -->
            <div class="pt-3 border-t border-slate-200 flex justify-between items-center text-sm font-semibold text-slate-700 font-sans">
                <span>Individual Value: ₹<span id="individual-value-calc">0.00</span></span>
                <span id="savings-display-calc" class="text-emerald-600 hidden">You Save: ₹<span>0.00</span></span>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.combos.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-250 text-slate-500 font-semibold text-sm hover:bg-slate-50 transition">
                Cancel
            </a>
            <button type="submit" class="bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md shadow-[#C49A6C]/20 transition cursor-pointer">
                Update Combo Pack
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

let selectedComboItems = [];

// Load old values if validation failed, otherwise load existing combo items
@if(old('combo_items'))
    selectedComboItems = @json(old('combo_items'));
    selectedComboItems.forEach(item => {
        const option = document.querySelector(`#product-search-select option[value="${item.product_id}"]`);
        if (option) {
            item.name = option.dataset.name;
            item.price = parseFloat(option.dataset.price);
            item.image = option.dataset.image;
        }
    });
@else
    selectedComboItems = [
        @foreach($product->comboItems as $item)
            @if($item->product)
            {
                product_id: {{ $item->product_id }},
                name: "{{ addslashes($item->product->name) }}",
                price: {{ $item->product->sale_price ?: $item->product->price }},
                image: "{{ json_decode($item->product->images)[0] ?? 'images/premium_dhoop_product.png' }}",
                quantity: {{ $item->quantity }}
            },
            @endif
        @endforeach
    ];
@endif

function addChildProduct() {
    const select = document.getElementById('product-search-select');
    const selectedOption = select.options[select.selectedIndex];
    
    if (!selectedOption.value) {
        alert("Please select a product.");
        return;
    }
    
    const productId = parseInt(selectedOption.value);
    const name = selectedOption.dataset.name;
    const price = parseFloat(selectedOption.dataset.price);
    const image = selectedOption.dataset.image;
    
    if (selectedComboItems.some(item => item.product_id === productId)) {
        alert("This product is already added to the combo.");
        return;
    }
    
    selectedComboItems.push({
        product_id: productId,
        name: name,
        price: price,
        image: image,
        quantity: 1
    });
    
    select.selectedIndex = 0;
    renderSelectedProducts();
}

function removeChildProduct(productId) {
    selectedComboItems = selectedComboItems.filter(item => item.product_id !== productId);
    renderSelectedProducts();
}

function updateChildQuantity(productId, qty) {
    const item = selectedComboItems.find(i => i.product_id === productId);
    if (item) {
        item.quantity = Math.max(1, parseInt(qty) || 1);
    }
    renderSelectedProducts();
}

function renderSelectedProducts() {
    const container = document.getElementById('selected-products-container');
    if (!container) return;
    container.innerHTML = '';
    
    let totalValue = 0;
    
    selectedComboItems.forEach((item, index) => {
        totalValue += item.price * item.quantity;
        
        const row = document.createElement('div');
        row.className = 'flex items-center justify-between bg-white p-3 rounded-xl border border-slate-150 gap-4';
        row.innerHTML = `
            <input type="hidden" name="combo_items[${index}][product_id]" value="${item.product_id}">
            <div class="flex items-center space-x-3 flex-1 min-w-0">
                <img src="/${item.image}" alt="${item.name}" class="w-10 h-10 object-contain border rounded p-0.5 bg-slate-50 flex-shrink-0">
                <span class="text-sm font-semibold text-slate-700 truncate" title="${item.name}">${item.name}</span>
            </div>
            <div class="text-xs text-slate-450 font-semibold min-w-[70px]">Value: ₹${(item.price * item.quantity).toFixed(2)}</div>
            <div class="flex items-center border border-slate-200 rounded-lg overflow-hidden bg-slate-50">
                <button type="button" class="w-8 h-8 flex items-center justify-center text-slate-500 hover:bg-slate-100 border-r border-slate-200" onclick="decrementQty(${item.product_id})">-</button>
                <input type="number" name="combo_items[${index}][quantity]" value="${item.quantity}" min="1" 
                       class="w-12 h-8 text-center border-none bg-transparent focus:ring-0 text-xs font-bold text-slate-700"
                       onchange="updateChildQuantity(${item.product_id}, this.value)">
                <button type="button" class="w-8 h-8 flex items-center justify-center text-slate-500 hover:bg-slate-100 border-l border-slate-200" onclick="incrementQty(${item.product_id})">+</button>
            </div>
            <button type="button" class="text-slate-400 hover:text-red-500 cursor-pointer" onclick="removeChildProduct(${item.product_id})">
                <i class="fa-regular fa-trash-can text-sm"></i>
            </button>
        `;
        container.appendChild(row);
    });
    
    document.getElementById('individual-value-calc').textContent = totalValue.toFixed(2);
    
    const priceInput = document.querySelector('input[name="price"]');
    const comboPrice = parseFloat(priceInput.value) || 0;
    const savings = totalValue - comboPrice;
    
    const savingsDisplay = document.getElementById('savings-display-calc');
    if (savings > 0 && selectedComboItems.length > 0) {
        savingsDisplay.querySelector('span').textContent = savings.toFixed(2);
        savingsDisplay.classList.remove('hidden');
    } else {
        savingsDisplay.classList.add('hidden');
    }
}

function decrementQty(productId) {
    const item = selectedComboItems.find(i => i.product_id === productId);
    if (item && item.quantity > 1) {
        item.quantity--;
        renderSelectedProducts();
    }
}

function incrementQty(productId) {
    const item = selectedComboItems.find(i => i.product_id === productId);
    if (item) {
        item.quantity++;
        renderSelectedProducts();
    }
}

document.querySelector('input[name="price"]').addEventListener('input', renderSelectedProducts);

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', renderSelectedProducts);
} else {
    renderSelectedProducts();
}
</script>
@endpush
