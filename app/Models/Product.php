<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function activeReviews()
    {
        return $this->hasMany(Review::class)->where('is_active', true);
    }

    public function getAverageRatingAttribute()
    {
        return round($this->activeReviews->avg('rating') ?? 0, 1);
    }

    public function getReviewsCountAttribute()
    {
        return $this->activeReviews->count();
    }

    // Combo relationships
    public function comboItems()
    {
        return $this->hasMany(ComboItem::class, 'combo_id');
    }

    public function comboProducts()
    {
        return $this->belongsToMany(Product::class, 'combo_items', 'combo_id', 'product_id')
                    ->withPivot('quantity');
    }

    // Dynamic stock override
    public function getQuantityAttribute($value)
    {
        if ($this->is_combo) {
            return app(\App\Services\ComboService::class)->getAvailableQuantity($this);
        }
        return $value;
    }

    // Value/Price calculations
    public function getIndividualValueAttribute()
    {
        if (!$this->is_combo) {
            return 0;
        }

        $total = 0;
        // Avoid N+1 queries by accessing relation
        foreach ($this->comboItems as $item) {
            if ($item->product) {
                $price = $item->product->sale_price ?: $item->product->price;
                $total += $price * $item->quantity;
            }
        }
        return $total;
    }

    public function getSavingsAttribute()
    {
        if (!$this->is_combo) {
            return 0;
        }

        $comboPrice = $this->sale_price ?: $this->price;
        $savings = $this->individual_value - $comboPrice;
        return max(0, $savings);
    }

    public function getDiscountPercentAttribute()
    {
        if (!$this->is_combo) {
            return 0;
        }

        $indValue = $this->individual_value;
        if ($indValue > 0) {
            return round(($this->savings / $indValue) * 100);
        }
        return 0;
    }
}
