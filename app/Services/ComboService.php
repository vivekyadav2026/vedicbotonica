<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemComponent;
use Illuminate\Support\Facades\DB;

class ComboService
{
    /**
     * Calculate the maximum quantity of this combo that can be sold based on its child items' stock.
     */
    public function getAvailableQuantity(Product $combo): int
    {
        // Prevent infinite recursion in case relationship is loaded recursively
        $comboItems = $combo->comboItems()->with('product')->get();

        if ($comboItems->isEmpty()) {
            return 0;
        }

        $minAvailable = null;

        foreach ($comboItems as $item) {
            if (!$item->product || !$item->product->is_active) {
                return 0; // If a child product is missing or inactive, combo is unavailable
            }

            $availableCombos = (int) floor($item->product->getRawOriginal('quantity') / $item->quantity);

            if ($minAvailable === null || $availableCombos < $minAvailable) {
                $minAvailable = $availableCombos;
            }
        }

        return $minAvailable ?? 0;
    }

    /**
     * Consolidate cart items and validate all items (normal and combo child components) against available stock.
     * Returns an array of error messages.
     */
    public function validateCartStock(array $cart): array
    {
        $errors = [];
        $requiredQuantities = [];
        $comboOrigins = []; // Track which combos demand which products

        // Consolidate required stock
        foreach ($cart as $id => $item) {
            // Check if standard product ID or virtual key
            $productId = $item['id'] ?? $id;
            $product = Product::find($productId);

            if (!$product) {
                continue;
            }

            if ($product->is_combo) {
                $comboItems = $product->comboItems()->with('product')->get();
                foreach ($comboItems as $subItem) {
                    if (!$subItem->product) {
                        $errors[] = "The combo '{$product->name}' contains unavailable products.";
                        continue;
                    }
                    $childId = $subItem->product_id;
                    $needed = $subItem->quantity * $item['quantity'];

                    $requiredQuantities[$childId] = ($requiredQuantities[$childId] ?? 0) + $needed;
                    $comboOrigins[$childId][] = [
                        'combo_name' => $product->name,
                        'qty_per_combo' => $subItem->quantity,
                        'total_qty' => $needed
                    ];
                }
            } else {
                $requiredQuantities[$productId] = ($requiredQuantities[$productId] ?? 0) + $item['quantity'];
            }
        }

        // Validate consolidated quantities
        foreach ($requiredQuantities as $productId => $totalNeeded) {
            $product = Product::find($productId);
            if (!$product) {
                continue;
            }

            $available = $product->getRawOriginal('quantity');
            if ($totalNeeded > $available) {
                if (isset($comboOrigins[$productId])) {
                    // Check which combo was the origin of demand
                    foreach ($comboOrigins[$productId] as $origin) {
                        $errors[] = "The combo pack '{$origin['combo_name']}' is temporarily unavailable because '{$product->name}' does not have enough stock (Only {$available} available).";
                    }
                } else {
                    $errors[] = "Only {$available} units of '{$product->name}' are available (Requested: {$totalNeeded}).";
                }
            }
        }

        return $errors;
    }

    /**
     * Atomically locks relevant database rows and deducts product/child stock for an order.
     * Throws an exception if any item has insufficient stock.
     */
    public function deductStock(Order $order): void
    {
        $items = $order->items()->with('product')->get();

        foreach ($items as $item) {
            $product = $item->product;

            if (!$product) {
                // If product is deleted but was ordered, skip stock deduction
                continue;
            }

            if ($product->is_combo) {
                $comboItems = $product->comboItems()->get();
                foreach ($comboItems as $subItem) {
                    // Lock child row for update
                    $childProduct = Product::lockForUpdate()->find($subItem->product_id);

                    if (!$childProduct) {
                        throw new \Exception("Component product (ID: {$subItem->product_id}) for combo '{$product->name}' is missing.");
                    }

                    $needed = $subItem->quantity * $item->quantity;

                    if ($childProduct->getRawOriginal('quantity') < $needed) {
                        throw new \Exception("Insufficient stock for component '{$childProduct->name}' in combo '{$product->name}'. Available: {$childProduct->getRawOriginal('quantity')}, Required: {$needed}.");
                    }

                    // Decrement child product stock
                    $childProduct->decrement('quantity', $needed);
                }

                // Log the historical components snapshot
                $this->createSnapshot($item, $product);
            } else {
                // Lock normal product row for update
                $normalProduct = Product::lockForUpdate()->find($product->id);

                if ($normalProduct->getRawOriginal('quantity') < $item->quantity) {
                    throw new \Exception("Insufficient stock for product '{$normalProduct->name}'. Available: {$normalProduct->getRawOriginal('quantity')}, Required: {$item->quantity}.");
                }

                // Decrement standard product stock
                $normalProduct->decrement('quantity', $item->quantity);
            }
        }
    }

    /**
     * Restore stock for a cancelled/failed order.
     */
    public function restoreStock(Order $order): void
    {
        $items = $order->items()->with(['product', 'components'])->get();

        foreach ($items as $item) {
            $product = $item->product;

            if ($product && $product->is_combo) {
                // Restore from historical components snapshot
                foreach ($item->components as $component) {
                    if ($component->product_id) {
                        Product::where('id', $component->product_id)
                            ->increment('quantity', $component->quantity);
                    }
                }
            } else {
                // Restore normal product
                if ($item->product_id) {
                    Product::where('id', $item->product_id)
                        ->increment('quantity', $item->quantity);
                }
            }
        }
    }

    /**
     * Restore stock for a specific returned order item and its components.
     */
    public function restoreItemStock(OrderItem $orderItem, int $qtyReturned): void
    {
        $product = $orderItem->product;

        if ($product && $product->is_combo) {
            // Restore from historical components snapshot proportionately
            foreach ($orderItem->components as $component) {
                if ($component->product_id && $orderItem->quantity > 0) {
                    $qtyPerItem = (int) ($component->quantity / $orderItem->quantity);
                    $toRestore = $qtyPerItem * $qtyReturned;
                    Product::where('id', $component->product_id)
                        ->increment('quantity', $toRestore);
                }
            }
        } else {
            // Restore normal product
            if ($orderItem->product_id) {
                Product::where('id', $orderItem->product_id)
                    ->increment('quantity', $qtyReturned);
            }
        }
    }

    /**
     * Create order item components snapshot records for historical orders.
     */
    public function createSnapshot(OrderItem $orderItem, Product $combo): void
    {
        $comboItems = $combo->comboItems()->with('product')->get();

        foreach ($comboItems as $subItem) {
            if (!$subItem->product) {
                continue;
            }

            OrderItemComponent::create([
                'order_item_id' => $orderItem->id,
                'product_id' => $subItem->product_id,
                'product_name' => $subItem->product->name,
                'quantity' => $subItem->quantity * $orderItem->quantity,
                'unit_price' => $subItem->product->sale_price ?: $subItem->product->price,
            ]);
        }
    }
}
