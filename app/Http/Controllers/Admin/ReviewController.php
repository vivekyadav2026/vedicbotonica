<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('product');

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reviewer_name', 'like', '%' . $search . '%')
                  ->orWhere('review', 'like', '%' . $search . '%')
                  ->orWhereHas('product', function ($pq) use ($search) {
                      $pq->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $reviews = $query->latest()->paginate(10)->withQueryString();
        $products = Product::orderBy('name')->get();

        return view('admin.reviews.index', compact('reviews', 'products'));
    }

    public function create(Request $request)
    {
        $products = Product::orderBy('name')->get();
        $selectedProductId = $request->query('product_id');

        return view('admin.reviews.create', compact('products', 'selectedProductId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'reviewer_name' => 'required|string|max:255',
            'reviewer_email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        Review::create([
            'product_id' => $request->product_id,
            'reviewer_name' => $request->reviewer_name,
            'reviewer_email' => $request->reviewer_email,
            'rating' => $request->rating,
            'review' => $request->review,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.reviews.index')->with('success', 'Product review added successfully.');
    }

    public function edit(Review $review)
    {
        $products = Product::orderBy('name')->get();
        return view('admin.reviews.edit', compact('review', 'products'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'reviewer_name' => 'required|string|max:255',
            'reviewer_email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        $review->update([
            'product_id' => $request->product_id,
            'reviewer_name' => $request->reviewer_name,
            'reviewer_email' => $request->reviewer_email,
            'rating' => $request->rating,
            'review' => $request->review,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.reviews.index')->with('success', 'Product review updated successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Product review deleted successfully.');
    }
}
