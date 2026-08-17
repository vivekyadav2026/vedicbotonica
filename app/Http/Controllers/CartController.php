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
            $product = Product::find($productId);
            $item['stock'] = $product ? $product->quantity : 0;
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
                $product = Product::find($productId);
                if ($product && $quantity > $product->quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => "Only {$product->quantity} items available in stock."
                    ], 400);
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
}
