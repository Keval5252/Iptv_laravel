<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'description',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class)->whereNull('parent_id')->ordered();
    }

    public function allMenuItems()
    {
        return $this->hasMany(MenuItem::class)->ordered();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('location', $location);
    }
}
