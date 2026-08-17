<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // Show Checkout Form
    public function index()
    {
        if (auth()->user() && auth()->user()->is_admin) {
            return redirect()->route('cart.index')->with('error', 'Admins are not allowed to place orders.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warning', 'Your cart is empty! Please add products before checking out.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('frontend.checkout', compact('cart', 'subtotal'));
    }

    // Place Order
    public function store(Request $request)
    {
        if (auth()->user() && auth()->user()->is_admin) {
            return redirect()->route('cart.index')->with('error', 'Admins are not allowed to place orders.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Validate shipping details
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_address2' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_zip' => 'required|string|max:10',
            'payment_method' => 'required|string|in:cod,razorpay',
            'notes' => 'nullable|string',
        ]);

        // Merge address lines into one full address
        $fullAddress = $validated['shipping_address'] . ', ' . $validated['shipping_address2'];

        // Auto-save user profile address if logged in
        if (auth()->check()) {
            auth()->user()->update([
                'phone' => $validated['shipping_phone'],
                'address' => $fullAddress,
                'city' => $validated['shipping_city'],
                'state' => $validated['shipping_state'],
                'zip' => $validated['shipping_zip'],
            ]);
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Generate a unique order number
        $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        // Create Order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => $orderNumber,
            'total_amount' => $subtotal,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'notes' => $validated['notes'] ?? null,
            'shipping_name' => $validated['shipping_name'],
            'shipping_email' => $validated['shipping_email'],
            'shipping_phone' => $validated['shipping_phone'],
            'shipping_address' => $fullAddress,
            'shipping_city' => $validated['shipping_city'],
            'shipping_state' => $validated['shipping_state'],
            'shipping_zip' => $validated['shipping_zip'],
        ]);

        // Create Order Items
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity'],
            ]);
        }

        // Check if payment method is Razorpay
        if ($validated['payment_method'] === 'razorpay') {
            try {
                $api = new \Razorpay\Api\Api(config('services.razorpay.key'), config('services.razorpay.secret'));
                
                $razorpayOrder = $api->order->create([
                    'receipt' => $order->order_number,
                    'amount' => (int) round($order->total_amount * 100), // in paise
                    'currency' => 'INR'
                ]);

                $order->update([
                    'razorpay_order_id' => $razorpayOrder['id']
                ]);

                return view('frontend.razorpay', [
                    'order' => $order,
                    'razorpayKey' => config('services.razorpay.key')
                ]);
            } catch (\Exception $e) {
                // If Razorpay order creation fails, fail order and redirect back
                $order->update([
                    'status' => 'failed',
                    'notes' => 'Razorpay Order Creation Failed: ' . $e->getMessage()
                ]);
                return redirect()->route('checkout.index')->with('error', 'Unable to initiate online payment: ' . $e->getMessage());
            }
        }

        // Clear session cart (COD flow)
        session()->forget('cart');

        return redirect()->route('checkout.success', ['order_number' => $order->order_number])
            ->with('success', 'Thank you! Your order has been placed successfully.');
    }

    // Handle Razorpay payment cancellation — restore cart and cancel order
    public function cancelRazorpayPayment(Request $request)
    {
        $orderId = $request->query('order_id');
        if ($orderId) {
            $order = Order::where('id', $orderId)
                ->where('payment_status', 'pending')
                ->with('items.product')
                ->first();

            if ($order) {
                // Restore cart from order items
                $cart = session()->get('cart', []);
                foreach ($order->items as $item) {
                    $cart[$item->product_id] = [
                        'name'     => $item->product_name,
                        'price'    => $item->unit_price,
                        'quantity' => $item->quantity,
                        'image'    => $item->product ? (json_decode($item->product->images)[0] ?? asset('images/premium_dhoop_product.png')) : asset('images/premium_dhoop_product.png'),
                    ];
                }
                session()->put('cart', $cart);

                // Mark order as cancelled
                $order->update([
                    'status'         => 'cancelled',
                    'payment_status' => 'failed',
                    'notes'          => 'Payment cancelled by user on Razorpay popup.',
                ]);
            }
        }

        return redirect()->route('checkout.index')->with('warning', 'Payment was cancelled. Your cart has been restored — please try again.');
    }

    // Razorpay Callback Verification
    public function handleRazorpayCallback(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->firstOrFail();

        try {
            $api = new \Razorpay\Api\Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            
            // Verify signature
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Update order status
            $order->update([
                'payment_status' => 'completed',
                'status' => 'processing', // Order starts processing once paid
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            // Clear session cart
            session()->forget('cart');

            return redirect()->route('checkout.success', ['order_number' => $order->order_number])
                ->with('success', 'Payment successful! Your order has been placed.');

        } catch (\Exception $e) {
            $order->update([
                'payment_status' => 'failed',
                'status' => 'failed',
                'notes' => 'Razorpay Signature Verification Failed: ' . $e->getMessage()
            ]);

            return redirect()->route('cart.index')->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }

    // Razorpay Webhook — server-to-server payment confirmation
    public function razorpayWebhook(Request $request)
    {
        $webhookSecret = config('services.razorpay.webhook_secret');
        $webhookBody   = $request->getContent();
        $webhookSignature = $request->header('X-Razorpay-Signature');

        // Verify webhook signature
        if ($webhookSecret && $webhookSignature) {
            $expectedSignature = hash_hmac('sha256', $webhookBody, $webhookSecret);
            if (!hash_equals($expectedSignature, $webhookSignature)) {
                Log::warning('Razorpay Webhook: Invalid signature received.');
                return response()->json(['status' => 'invalid_signature'], 400);
            }
        }

        $payload = $request->json()->all();
        $event   = $payload['event'] ?? null;

        Log::info('Razorpay Webhook received: ' . $event);

        if ($event === 'payment.captured') {
            $paymentEntity = $payload['payload']['payment']['entity'] ?? null;
            if (!$paymentEntity) {
                return response()->json(['status' => 'no_payload'], 200);
            }

            $razorpayOrderId = $paymentEntity['order_id'] ?? null;
            $paymentId       = $paymentEntity['id'] ?? null;

            if ($razorpayOrderId) {
                $order = Order::where('razorpay_order_id', $razorpayOrderId)->first();
                if ($order && $order->payment_status !== 'completed') {
                    $order->update([
                        'payment_status'      => 'completed',
                        'status'              => 'processing',
                        'razorpay_payment_id' => $paymentId,
                    ]);
                    // Clear cart for this user if still in session
                    Log::info('Razorpay Webhook: Order ' . $order->order_number . ' marked as completed via webhook.');
                }
            }
        }

        if ($event === 'payment.failed') {
            $paymentEntity = $payload['payload']['payment']['entity'] ?? null;
            $razorpayOrderId = $paymentEntity['order_id'] ?? null;
            if ($razorpayOrderId) {
                $order = Order::where('razorpay_order_id', $razorpayOrderId)->first();
                if ($order && $order->payment_status === 'pending') {
                    $order->update([
                        'payment_status' => 'failed',
                        'status'         => 'failed',
                        'notes'          => 'Payment failed via Razorpay webhook: ' . ($paymentEntity['error_description'] ?? 'unknown'),
                    ]);
                }
            }
        }

        return response()->json(['status' => 'ok'], 200);
    }

    // Order Success landing page
    public function success($order_number)
    {
        // Allow guest viewing via order_number lookup (no user_id restriction for guests)
        $query = Order::where('order_number', $order_number)->with('items');

        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        }

        $order = $query->firstOrFail();
        return view('frontend.order_success', compact('order'));
    }
}
