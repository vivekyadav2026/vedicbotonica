<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Get cart contents
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Load actual stock level for each item in the cart
        foreach ($cart as $productId => &$item) {
            if (str_starts_with($productId, 'bundle_')) {
                $item['stock'] = 99; // Virtual bundle fallback
            } else {
                $product = Product::find($productId);
                $item['stock'] = $product ? $product->quantity : 0;
            }
        }
        
        return view('frontend.cart', compact('cart'));
    }

    // Add to cart
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity <= 0) {
            return response()->json(['success' => false, 'message' => 'Quantity must be at least 1.'], 400);
        }

        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }

        $cart = session()->get('cart', []);
        $currentQtyInCart = isset($cart[$productId]) ? (int) $cart[$productId]['quantity'] : 0;
        $newTotalQty = $currentQtyInCart + $quantity;

        if ($newTotalQty > $product->quantity) {
            return response()->json([
                'success' => false,
                'message' => "Only {$product->quantity} items available in stock." . ($currentQtyInCart > 0 ? " (You already have {$currentQtyInCart} in your cart)" : "")
            ], 400);
        }

        // Prepare image
        $images = json_decode($product->images);
        $image = ($images && count($images) > 0) ? asset($images[0]) : 'https://images.unsplash.com/photo-1599643478524-fb5244098775?w=500&q=80';

        $price = $product->sale_price ?? $product->price;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $price,
                'image' => $image,
                'slug' => $product->slug
            ];
        }

        session()->put('cart', $cart);

        $totalCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => $totalCount,
            'cart' => $cart
        ]);
    }

    // Update cart item quantity
    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity');

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                if (str_starts_with($productId, 'bundle_')) {
                    if ($quantity > 99) {
                        return response()->json([
                            'success' => false,
                            'message' => "Maximum 99 bundles allowed."
                        ], 400);
                    }
                } else {
                    $product = Product::find($productId);
                    if ($product && $quantity > $product->quantity) {
                        return response()->json([
                            'success' => false,
                            'message' => "Only {$product->quantity} items available in stock."
                        ], 400);
                    }
                }
                $cart[$productId]['quantity'] = $quantity;
            }
            session()->put('cart', $cart);
        }

        $totalCount = array_sum(array_column($cart, 'quantity'));
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'cart_count' => $totalCount,
            'total_price' => $totalPrice,
            'cart' => $cart
        ]);
    }

    // Remove from cart
    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        $totalCount = array_sum(array_column($cart, 'quantity'));
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart successfully!',
            'cart_count' => $totalCount,
            'total_price' => $totalPrice,
            'cart' => $cart
        ]);
    }

    // Get cart item count
    public function count()
    {
        $cart = session()->get('cart', []);
        $totalCount = array_sum(array_column($cart, 'quantity'));
        return response()->json(['cart_count' => $totalCount]);
    }

    // Add dynamic bundle pack to cart
    public function addBundle(Request $request)
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->all();
        $status = $settings['bundle_status'] ?? '0';

        if ($status !== '1') {
            return response()->json(['success' => false, 'message' => 'The Custom Bundle offer is currently inactive.'], 400);
        }

        $title = $settings['bundle_title'] ?? '5 Divine Essentials';
        $targetQty = intval($settings['bundle_quantity'] ?? 5);
        $price = floatval($settings['bundle_price'] ?? 799);

        $request->validate([
            'product_ids' => 'required|array',
        ]);

        $productIds = $request->input('product_ids');

        if (count($productIds) !== $targetQty) {
            return response()->json(['success' => false, 'message' => "You must select exactly {$targetQty} products for the bundle."], 400);
        }

        // Count selected items by ID
        $counts = array_count_values($productIds);
        $bundleItems = [];

        foreach ($counts as $prodId => $qty) {
            $product = Product::find($prodId);
            if (!$product || !$product->is_active || !$product->eligible_for_bundle) {
                return response()->json(['success' => false, 'message' => 'One or more of the selected products is invalid or unavailable.'], 400);
            }

            if ($product->quantity < $qty) {
                return response()->json(['success' => false, 'message' => "Product '{$product->name}' does not have enough stock (Only {$product->quantity} available)."], 400);
            }

            $images = json_decode($product->images, true);
            $image = ($images && count($images) > 0) ? asset($images[0]) : asset('images/premium_dhoop_product.png');

            $bundleItems[] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $qty,
                'image' => $image,
                'slug' => $product->slug
            ];
        }

        // Add to cart session
        $cart = session()->get('cart', []);
        $bundleKey = 'bundle_' . uniqid();
        $cart[$bundleKey] = [
            'name' => $title,
            'quantity' => 1,
            'price' => $price,
            'image' => asset('images/premium_combo_category.png'),
            'slug' => null,
            'is_bundle' => true,
            'bundle_items' => $bundleItems
        ];

        session()->put('cart', $cart);
        $totalCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'message' => 'Bundle added to cart successfully!',
            'cart_count' => $totalCount,
            'cart' => $cart
        ]);
    }
}
