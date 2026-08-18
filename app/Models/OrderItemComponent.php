<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemComponent extends Model
{
    protected $guarded = [];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
