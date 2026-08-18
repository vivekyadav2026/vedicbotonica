<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ReturnRequest;
use App\Models\ReturnRequestItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    /**
     * Show return request form.
     */
    public function create(Order $order)
    {
        // Security check: order must belong to logged-in user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Status check: only completed orders can be returned
        if ($order->status !== 'completed') {
            return redirect()->route('dashboard')->with('error', 'Only delivered/completed orders can be returned.');
        }

        // Return window check: 15 days
        if ($order->created_at->diffInDays(now()) > 15) {
            return redirect()->route('dashboard')->with('error', 'The 15-day return window for this order has expired.');
        }

        // Check if there is already an active return request for this order
        $existingRequest = ReturnRequest::where('order_id', $order->id)->first();
        if ($existingRequest) {
            return redirect()->route('dashboard')->with('info', 'A return request has already been submitted for this order (Status: ' . ucfirst($existingRequest->status) . ').');
        }

        $order->load('items.product');

        return view('frontend.orders.return', compact('order'));
    }

    /**
     * Store return request.
     */
    public function store(Request $request, Order $order)
    {
        // Security check
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Status check
        if ($order->status !== 'completed') {
            return redirect()->route('dashboard')->with('error', 'Only completed orders can be returned.');
        }

        // Return window check
        if ($order->created_at->diffInDays(now()) > 15) {
            return redirect()->route('dashboard')->with('error', 'The 15-day return window has expired.');
        }

        // Duplicate request check
        $existingRequest = ReturnRequest::where('order_id', $order->id)->first();
        if ($existingRequest) {
            return redirect()->route('dashboard')->with('info', 'A return request has already been submitted.');
        }

        // Validate reason and items selection
        $request->validate([
            'reason' => 'required|string|max:1000',
            'items' => 'required|array|min:1',
        ]);

        // Filter and check items
        $selectedItems = array_filter($request->items, function($item) {
            return !empty($item['selected']);
        });

        if (count($selectedItems) === 0) {
            return redirect()->back()->withInput()->with('error', 'Please select at least one item to return.');
        }

        try {
            DB::transaction(function() use ($order, $request, $selectedItems) {
                // Create Return Request
                $returnRequest = ReturnRequest::create([
                    'order_id' => $order->id,
                    'user_id' => Auth::id(),
                    'reason' => $request->reason,
                    'status' => 'pending',
                ]);

                foreach ($selectedItems as $itemId => $itemData) {
                    $orderItem = OrderItem::where('order_id', $order->id)->findOrFail($itemId);
                    $qty = (int) ($itemData['quantity'] ?? 1);

                    // Validate return quantity bounds
                    if ($qty < 1 || $qty > $orderItem->quantity) {
                        throw new \Exception("Invalid return quantity for '{$orderItem->product_name}'. Purchased: {$orderItem->quantity}, Requested: {$qty}.");
                    }

                    ReturnRequestItem::create([
                        'return_request_id' => $returnRequest->id,
                        'order_item_id' => $orderItem->id,
                        'quantity' => $qty,
                    ]);
                }
            });

            return redirect()->route('dashboard')->with('success', 'Your return request has been submitted successfully and is pending review.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to submit return request: ' . $e->getMessage());
        }
    }
}
