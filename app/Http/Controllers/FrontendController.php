<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Testimonial;

class FrontendController extends Controller
{
    public function home()
    {
        $banners = Banner::where('is_active', true)->get();
        $testimonials = Testimonial::where('is_active', true)->get();
        $bestSellers = Product::where('is_active', true)->where('is_bestseller', true)->latest()->take(8)->get();
        $featuredProducts = Product::where('is_active', true)->where('is_featured', true)->latest()->take(8)->get();
        $dealOfWeek = Product::where('is_active', true)->where('deal_of_week', true)->first();
        $categories = Category::where('is_active', true)->get();

        // Fallbacks if database has no flagged products, keeping the sections distinct
        if ($bestSellers->isEmpty()) {
            $bestSellers = Product::where('is_active', true)->where('is_featured', false)->latest()->take(8)->get();
            if ($bestSellers->isEmpty()) {
                $bestSellers = Product::where('is_active', true)->latest()->take(8)->get();
            }
        }
        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::where('is_active', true)->where('is_bestseller', false)->latest()->take(8)->get();
            if ($featuredProducts->isEmpty()) {
                $featuredProducts = Product::where('is_active', true)->latest()->take(8)->get();
            }
        }

        return view('frontend.home', compact('banners', 'testimonials', 'bestSellers', 'featuredProducts', 'dealOfWeek', 'categories'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function shop(Request $request)
    {
        $query = Product::where('is_active', true);

        // Filter by search query
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Filter by categories
        if ($request->has('categories')) {
            $query->whereIn('category_id', $request->input('categories'));
        }

        // Filter by highlights
        if ($request->has('highlight')) {
            $highlight = $request->input('highlight');
            if ($highlight == 'bestseller') {
                $query->where('is_bestseller', true);
            } elseif ($highlight == 'new') {
                $query->latest();
            } elseif ($highlight == 'sale') {
                $query->whereNotNull('sale_price');
            }
        }

        // Filter by price range
        if ($request->has('price_range')) {
            $range = $request->input('price_range');
            if ($range == 'under_200') {
                $query->where(function($q) {
                    $q->where(function($sub) {
                        $sub->whereNull('sale_price')->where('price', '<', 200);
                    })->orWhere(function($sub) {
                        $sub->whereNotNull('sale_price')->where('sale_price', '<', 200);
                    });
                });
            } elseif ($range == '200_300') {
                $query->where(function($q) {
                    $q->where(function($sub) {
                        $sub->whereNull('sale_price')->whereBetween('price', [200, 300]);
                    })->orWhere(function($sub) {
                        $sub->whereNotNull('sale_price')->whereBetween('sale_price', [200, 300]);
                    });
                });
            } elseif ($range == 'above_300') {
                $query->where(function($q) {
                    $q->where(function($sub) {
                        $sub->whereNull('sale_price')->where('price', '>', 300);
                    })->orWhere(function($sub) {
                        $sub->whereNotNull('sale_price')->where('sale_price', '>', 300);
                    });
                });
            }
        }

        // Sort products
        if ($request->has('sort_by')) {
            $sort = $request->input('sort_by');
            if ($sort == 'price_low') {
                $query->orderByRaw('COALESCE(sale_price, price) asc');
            } elseif ($sort == 'price_high') {
                $query->orderByRaw('COALESCE(sale_price, price) desc');
            } elseif ($sort == 'latest') {
                $query->latest();
            } else {
                $query->orderBy('id', 'desc');
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('frontend.shop', compact('products', 'categories'));
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(4)->get();
        return view('frontend.product', compact('product', 'relatedProducts'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function apiProductDetails($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->with('category')->first();
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }
        
        $images = json_decode($product->images);
        $image = ($images && count($images) > 0) ? asset($images[0]) : 'https://images.unsplash.com/photo-1599643478524-fb5244098775?w=500&q=80';
        
        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'image' => $image,
                'description' => $product->description,
                'short_description' => $product->short_description,
                'slug' => $product->slug,
                'category_name' => $product->category->name ?? 'Dhoop Sticks',
                'quantity' => $product->quantity
            ]
        ]);
    }

    public function terms()
    {
        return view('frontend.terms');
    }

    public function privacy()
    {
        return view('frontend.privacy');
    }

    public function refund()
    {
        return view('frontend.refund');
    }

    public function cancellation()
    {
        return view('frontend.cancellation');
    }

    public function shipping()
    {
        return view('frontend.shipping');
    }
}
