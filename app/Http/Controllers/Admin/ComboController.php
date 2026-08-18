<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ComboController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_combo', true)->with(['category', 'activeReviews']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $combos = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::whereHas('products', function($q) {
            $q->where('is_combo', true);
        })->get();

        return view('admin.combos.index', compact('combos', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.combos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|unique:products,sku',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0.001',
            'length' => 'required|integer|min:1',
            'width' => 'required|integer|min:1',
            'height' => 'required|integer|min:1',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
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

        DB::transaction(function() use ($request, $imagePaths) {
            $product = Product::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'sku' => $request->sku ?: 'VB-' . strtoupper(Str::random(6)),
                'quantity' => 0,
                'is_combo' => true,
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

            foreach ($request->combo_items as $subItem) {
                $product->comboItems()->create([
                    'product_id' => $subItem['product_id'],
                    'quantity' => $subItem['quantity'],
                ]);
            }
        });

        return redirect()->route('admin.combos.index')->with('success', 'Combo Pack created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.combos.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0.001',
            'length' => 'required|integer|min:1',
            'width' => 'required|integer|min:1',
            'height' => 'required|integer|min:1',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
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

        $existingImages = json_decode($product->images, true) ?? [];

        if ($request->has('remove_images')) {
            $existingImages = array_filter($existingImages, function($img) use ($request) {
                return !in_array($img, $request->remove_images);
            });
        }

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

        if (empty($existingImages)) {
            $existingImages[] = 'images/premium_dhoop_product.png';
        }

        DB::transaction(function() use ($product, $request, $existingImages) {
            $product->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'sku' => $request->sku ?: $product->sku,
                'quantity' => 0,
                'is_combo' => true,
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

            $product->comboItems()->delete();
            foreach ($request->combo_items as $subItem) {
                $product->comboItems()->create([
                    'product_id' => $subItem['product_id'],
                    'quantity' => $subItem['quantity'],
                ]);
            }
        });

        return redirect()->route('admin.combos.index')->with('success', 'Combo Pack updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $activeComboCount = \App\Models\ComboItem::where('product_id', $product->id)->count();
        if ($activeComboCount > 0) {
            return redirect()->route('admin.combos.index')
                ->with('error', "This product is currently used in {$activeComboCount} combo packs. Remove it from those combos before deleting.");
        }

        $product->comboItems()->delete();
        $product->delete();

        return redirect()->route('admin.combos.index')->with('success', 'Combo Pack deleted successfully.');
    }
}
