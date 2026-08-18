<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_combo', false)->with(['category', 'activeReviews']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::whereHas('products', function($q) {
            $q->where('is_combo', false);
        })->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $isCombo = $request->has('is_combo');

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|unique:products,sku',
            'quantity' => $isCombo ? 'nullable|integer' : 'required|integer|min:0',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0.001',
            'length' => 'required|integer|min:1',
            'width' => 'required|integer|min:1',
            'height' => 'required|integer|min:1',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($isCombo) {
            $request->validate([
                'combo_items' => 'required|array|min:1',
                'combo_items.*.product_id' => 'required|exists:products,id',
                'combo_items.*.quantity' => 'required|integer|min:1',
            ]);

            $childIds = array_column($request->combo_items, 'product_id');
            if (count($childIds) !== count(array_unique($childIds))) {
                return redirect()->back()->withInput()->withErrors(['combo_items' => 'Duplicate products are not allowed in a combo.']);
            }

            foreach ($request->combo_items as $subItem) {
                $child = Product::find($subItem['product_id']);
                if ($child->is_combo) {
                    return redirect()->back()->withInput()->withErrors(['combo_items' => 'A combo product cannot contain another combo product.']);
                }
            }
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            $path = public_path('uploads/products');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            foreach ($request->file('images') as $file) {
                $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $name);
                $imagePaths[] = 'uploads/products/' . $name;
            }
        }

        if (empty($imagePaths)) {
            $imagePaths[] = 'images/premium_dhoop_product.png';
        }

        DB::transaction(function() use ($request, $isCombo, $imagePaths) {
            $product = Product::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'sku' => $request->sku ?: 'VB-' . strtoupper(Str::random(6)),
                'quantity' => $isCombo ? 0 : $request->quantity,
                'is_combo' => $isCombo,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'is_featured' => $request->has('is_featured'),
                'is_bestseller' => $request->has('is_bestseller'),
                'deal_of_week' => $request->has('deal_of_week'),
                'is_active' => $request->has('is_active'),
                'weight' => $request->weight,
                'length' => $request->length,
                'width' => $request->width,
                'height' => $request->height,
                'images' => json_encode($imagePaths)
            ]);

            if ($isCombo) {
                foreach ($request->combo_items as $subItem) {
                    $product->comboItems()->create([
                        'product_id' => $subItem['product_id'],
                        'quantity' => $subItem['quantity'],
                    ]);
                }
            }
        });

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $isCombo = $request->has('is_combo');

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'quantity' => $isCombo ? 'nullable|integer' : 'required|integer|min:0',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0.001',
            'length' => 'required|integer|min:1',
            'width' => 'required|integer|min:1',
            'height' => 'required|integer|min:1',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($isCombo) {
            $request->validate([
                'combo_items' => 'required|array|min:1',
                'combo_items.*.product_id' => 'required|exists:products,id',
                'combo_items.*.quantity' => 'required|integer|min:1',
            ]);

            $childIds = array_column($request->combo_items, 'product_id');
            if (count($childIds) !== count(array_unique($childIds))) {
                return redirect()->back()->withInput()->withErrors(['combo_items' => 'Duplicate products are not allowed in a combo.']);
            }

            if (in_array($product->id, $childIds)) {
                return redirect()->back()->withInput()->withErrors(['combo_items' => 'A combo product cannot contain itself.']);
            }

            foreach ($request->combo_items as $subItem) {
                $child = Product::find($subItem['product_id']);
                if ($child->is_combo) {
                    return redirect()->back()->withInput()->withErrors(['combo_items' => 'A combo product cannot contain another combo product.']);
                }
            }
        }

        $existingImages = json_decode($product->images, true) ?? [];

        // Handle removing checked images
        if ($request->has('remove_images')) {
            $existingImages = array_filter($existingImages, function($img) use ($request) {
                return !in_array($img, $request->remove_images);
            });
        }

        // Handle uploading new images
        if ($request->hasFile('images')) {
            $path = public_path('uploads/products');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            foreach ($request->file('images') as $file) {
                $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $name);
                $existingImages[] = 'uploads/products/' . $name;
            }
        }

        // If all images removed, add the default fallback
        if (empty($existingImages)) {
            $existingImages[] = 'images/premium_dhoop_product.png';
        }

        DB::transaction(function() use ($product, $request, $isCombo, $existingImages) {
            $product->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'sku' => $request->sku ?: $product->sku,
                'quantity' => $isCombo ? 0 : $request->quantity,
                'is_combo' => $isCombo,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'is_featured' => $request->has('is_featured'),
                'is_bestseller' => $request->has('is_bestseller'),
                'deal_of_week' => $request->has('deal_of_week'),
                'is_active' => $request->has('is_active'),
                'weight' => $request->weight,
                'length' => $request->length,
                'width' => $request->width,
                'height' => $request->height,
                'images' => json_encode(array_values($existingImages))
            ]);

            if ($isCombo) {
                $product->comboItems()->delete();
                foreach ($request->combo_items as $subItem) {
                    $product->comboItems()->create([
                        'product_id' => $subItem['product_id'],
                        'quantity' => $subItem['quantity'],
                    ]);
                }
            } else {
                $product->comboItems()->delete();
            }
        });

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $activeComboCount = \App\Models\ComboItem::where('product_id', $product->id)->count();
        if ($activeComboCount > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', "This product is currently used in {$activeComboCount} combo packs. Remove it from those combos before deleting.");
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
