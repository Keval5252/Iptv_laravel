<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'duration',
        'price',
        'original_price',
        'features',
        'is_popular',
        'is_active',
        'sort_order',
        'display_pages',
        'stripe_plan_id',
        'stripe_product_id'
    ];

    protected $casts = [
        'features' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'display_pages' => 'array'
    ];

    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function stripePayments()
    {
        return $this->hasMany(StripePayment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function scopeByPage($query, $page)
    {
        return $query->whereJsonContains('display_pages', $page);
    }

    // Accessor for formatted price
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    // Accessor for formatted original price
    public function getFormattedOriginalPriceAttribute()
    {
        return '$' . number_format($this->original_price, 2);
    }

    // Accessor for discount percentage
    public function getDiscountPercentageAttribute()
    {
        if ($this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }
}
