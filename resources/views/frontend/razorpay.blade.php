@extends('layouts.frontend')

@section('title', 'Processing Payment')

@section('content')
    <div class="max-w-md mx-auto px-4 py-24 text-center">
        <div class="flex flex-col items-center justify-center space-y-6">
            <div class="h-16 w-16 border-4 border-[#C49A6C]/30 border-t-[#C49A6C] rounded-full animate-spin"></div>
            <h2 class="text-2xl font-serif font-bold text-gray-900">Initiating Payment</h2>
            <p class="text-sm text-gray-500 max-w-xs">Please complete your payment in the secure Razorpay popup window. Do not close or refresh this page.</p>
            
            <button id="rzp-button1" class="bg-[#C49A6C] hover:bg-[#A37B50] text-white font-bold py-3 px-8 rounded-xl text-sm transition shadow mt-4 cursor-pointer" style="background-color: #C49A6C; color: white;">
                Re-open Payment Window
            </button>

            <a href="{{ route('checkout.razorpay.cancel', ['order_id' => $order->id]) }}"
               class="text-xs text-gray-400 hover:text-red-500 underline mt-2 cursor-pointer transition">
                Cancel payment &amp; go back to checkout
            </a>
        </div>
    </div>

    <!-- Hidden form to submit verification details -->
    <form id="razorpay-form" action="{{ route('checkout.razorpay.callback') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id">
        <input type="hidden" id="razorpay_order_id" name="razorpay_order_id">
        <input type="hidden" id="razorpay_signature" name="razorpay_signature">
    </form>
@endsection

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var cancelUrl = "{{ route('checkout.razorpay.cancel', ['order_id' => $order->id]) }}";

    var options = {
        "key": "{{ $razorpayKey }}",
        "amount": "{{ $order->total_amount * 100 }}",
        "currency": "INR",
        "name": "Vedicbotanica",
        "description": "Order #{{ $order->order_number }}",
        "order_id": "{{ $order->razorpay_order_id }}",
        "handler": function (response) {
            // Payment successful — submit callback form
            document.getElementById('rzp-button1').disabled = true;
            document.getElementById('rzp-button1').innerText = 'Verifying payment...';
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('razorpay-form').submit();
        },
        "prefill": {
            "name": "{{ $order->shipping_name }}",
            "email": "{{ $order->shipping_email }}",
            "contact": "{{ $order->shipping_phone }}"
        },
        "theme": {
            "color": "#C49A6C"
        },
        "modal": {
            "ondismiss": function () {
                // User closed the popup — restore cart and mark order cancelled
                window.location.href = cancelUrl;
            }
        }
    };

    var rzp1 = new Razorpay(options);

    // Handle payment failure (wrong card, insufficient funds, etc.)
    rzp1.on('payment.failed', function (response) {
        window.location.href = cancelUrl + '&reason=' + encodeURIComponent(response.error.description);
    });

    // Open immediately on load
    window.addEventListener('DOMContentLoaded', function () {
        rzp1.open();
    });

    // Re-open click handler
    document.getElementById('rzp-button1').onclick = function (e) {
        rzp1.open();
        e.preventDefault();
    };
</script>
@endpush
