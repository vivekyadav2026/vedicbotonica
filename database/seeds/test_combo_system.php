<?php

// Bootstrap Laravel
require __DIR__ . '/../../../../../../xampp/htdocs/vedicbotonica/vendor/autoload.php';
$app = require_once __DIR__ . '/../../../../../../xampp/htdocs/vedicbotonica/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemComponent;
use App\Models\ComboItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

echo "Starting Fixed Combo Pack System Integration Verification...\n";

// Find a test user
$user = User::first() ?: User::create([
    'name' => 'Test Customer',
    'email' => 'test_customer_' . uniqid() . '@example.com',
    'password' => bcrypt('password'),
]);

echo "Using User: ID {$user->id} ({$user->name})\n";

DB::beginTransaction();

try {
    // Find or create category
    $category = \App\Models\Category::first() ?: \App\Models\Category::create(['name' => 'Dhoop Cones', 'slug' => 'dhoop-cones']);
    $catId = $category->id;

    // 1. Create Child Products (Ingredients)
    $sandal = Product::create([
        'category_id' => $catId,
        'name' => 'Test Sandal Dhoop',
        'slug' => 'test-sandal-dhoop',
        'price' => 200.00,
        'quantity' => 10,
        'weight' => 0.1, 'length' => 10, 'width' => 5, 'height' => 5,
        'images' => json_encode(['images/premium_dhoop_product.png']),
        'is_active' => true,
    ]);
    
    $jasmine = Product::create([
        'category_id' => $catId,
        'name' => 'Test Jasmine Dhoop',
        'slug' => 'test-jasmine-dhoop',
        'price' => 250.00,
        'quantity' => 20,
        'weight' => 0.1, 'length' => 10, 'width' => 5, 'height' => 5,
        'images' => json_encode(['images/premium_dhoop_product.png']),
        'is_active' => true,
    ]);

    $rose = Product::create([
        'category_id' => $catId,
        'name' => 'Test Rose Dhoop',
        'slug' => 'test-rose-dhoop',
        'price' => 150.00,
        'quantity' => 5,
        'weight' => 0.1, 'length' => 10, 'width' => 5, 'height' => 5,
        'images' => json_encode(['images/premium_dhoop_product.png']),
        'is_active' => true,
    ]);

    echo "Created child products with stocks: Sandal(10), Jasmine(20), Rose(5).\n";

    // 2. Create Combo Product
    $combo = Product::create([
        'category_id' => $catId,
        'name' => 'Test Daily Puja Combo',
        'slug' => 'test-daily-puja-combo',
        'price' => 399.00,
        'is_combo' => true,
        'quantity' => 0,
        'weight' => 0.3, 'length' => 10, 'width' => 5, 'height' => 5,
        'images' => json_encode(['images/premium_dhoop_product.png']),
        'is_active' => true,
    ]);

    // Create combo items definition
    // Sandal x 2, Jasmine x 1, Rose x 1
    $combo->comboItems()->create(['product_id' => $sandal->id, 'quantity' => 2]);
    $combo->comboItems()->create(['product_id' => $jasmine->id, 'quantity' => 1]);
    $combo->comboItems()->create(['product_id' => $rose->id, 'quantity' => 1]);

    echo "Created Combo: Sandal x 2, Jasmine x 1, Rose x 1. Combo Selling Price: ₹399.00\n";

    // 3. Test Dynamic Quantity Calculation
    $availableQty = $combo->quantity;
    echo "Computed Combo Stock: {$availableQty} (Expected: 5)\n";
    if ($availableQty !== 5) {
        throw new \Exception("Assertion Failed: Expected combo stock 5, got {$availableQty}");
    }
    echo "✓ Stock Calculation Check passed.\n";

    // 4. Test Dynamic Value / Savings / Discount accessors
    $indVal = $combo->individual_value;
    $savings = $combo->savings;
    $discPercent = $combo->discount_percent;

    echo "Calculated Combo Stats: Value ₹{$indVal}, Savings ₹{$savings}, Discount {$discPercent}%\n";
    if ($indVal != 800.00 || $savings != 401.00 || $discPercent != 50) {
        throw new \Exception("Assertion Failed: Combo value/savings math is incorrect.");
    }
    echo "✓ Pricing Accessors Check passed.\n";

    // 5. Test Cart Validation Success
    $cart = [
        $combo->id => [
            'id' => $combo->id,
            'name' => $combo->name,
            'price' => 399.00,
            'quantity' => 2,
        ]
    ];
    $errors = app(\App\Services\ComboService::class)->validateCartStock($cart);
    echo "Cart Stock Validation Errors Count: " . count($errors) . "\n";
    if (!empty($errors)) {
        throw new \Exception("Assertion Failed: Cart stock validation failed when stock should be sufficient.");
    }
    echo "✓ Cart Validation Success Check passed.\n";

    // 6. Test Cart Validation Failure
    $badCart = [
        $combo->id => [
            'id' => $combo->id,
            'name' => $combo->name,
            'price' => 399.00,
            'quantity' => 6,
        ]
    ];
    $errorsBad = app(\App\Services\ComboService::class)->validateCartStock($badCart);
    echo "Bad Cart Stock Validation Errors: " . implode(' ', $errorsBad) . "\n";
    if (empty($errorsBad)) {
        throw new \Exception("Assertion Failed: Bad cart was not rejected.");
    }
    echo "✓ Cart Validation Failure Check passed.\n";

    // 7. Test Checkout Placement & Atomic Stock Deduction
    $order = Order::create([
        'user_id' => $user->id,
        'order_number' => 'ORD-TEST-' . strtoupper(Str::random(4)),
        'total_amount' => 399.00 * 2,
        'status' => 'pending', 'payment_status' => 'pending', 'payment_method' => 'cod',
        'shipping_name' => 'John', 'shipping_email' => 'john@example.com', 'shipping_phone' => '123',
        'shipping_address' => 'Test', 'shipping_city' => 'Delhi', 'shipping_state' => 'Delhi', 'shipping_zip' => '110'
    ]);

    $item = OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $combo->id,
        'product_name' => $combo->name,
        'quantity' => 2,
        'unit_price' => 399.00,
        'total_price' => 798.00
    ]);

    // Perform deduction
    app(\App\Services\ComboService::class)->deductStock($order);

    // Verify child stocks
    $sandalStock = Product::find($sandal->id)->getRawOriginal('quantity');
    $jasmineStock = Product::find($jasmine->id)->getRawOriginal('quantity');
    $roseStock = Product::find($rose->id)->getRawOriginal('quantity');

    echo "Deducted Stock Levels: Sandal={$sandalStock}, Jasmine={$jasmineStock}, Rose={$roseStock}\n";
    if ($sandalStock != 6 || $jasmineStock != 18 || $roseStock != 3) {
        throw new \Exception("Assertion Failed: Child products inventory decrement failed.");
    }
    echo "✓ Atomic Stock Deduction Check passed.\n";

    // 8. Test Historical Components Snapshot creation
    $snapshots = OrderItemComponent::where('order_item_id', $item->id)->get();
    echo "Created Components Snapshot Count: " . $snapshots->count() . "\n";
    if ($snapshots->count() !== 3) {
        throw new \Exception("Assertion Failed: Components snapshot not created correctly.");
    }
    echo "✓ Components Snapshot Creation Check passed.\n";

    // 9. Test Stock Restoration on Cancel
    app(\App\Services\ComboService::class)->restoreStock($order);
    
    // Child stock levels should go back to original
    $sandalStockRestored = Product::find($sandal->id)->getRawOriginal('quantity');
    $jasmineStockRestored = Product::find($jasmine->id)->getRawOriginal('quantity');
    $roseStockRestored = Product::find($rose->id)->getRawOriginal('quantity');

    echo "Restored Stock Levels: Sandal={$sandalStockRestored}, Jasmine={$jasmineStockRestored}, Rose={$roseStockRestored}\n";
    if ($sandalStockRestored != 10 || $jasmineStockRestored != 20 || $roseStockRestored != 5) {
        throw new \Exception("Assertion Failed: Stock restoration failed.");
    }
    echo "✓ Stock Restoration Check passed.\n";

    echo "All Verification Checks Passed Successfully!\n";
    
} catch (\Exception $e) {
    echo "VERIFICATION ERROR: " . $e->getMessage() . "\n";
} finally {
    // Rollback transaction to keep DB clean
    DB::rollBack();
    echo "Database changes rolled back. Database remains clean!\n";
}
