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
}
