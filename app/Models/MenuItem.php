<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'parent_id',
        'title',
        'url',
        'route_name',
        'target',
        'icon',
        'css_class',
        'is_active',
        'sort_order',
        'settings'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->ordered();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function getFinalUrlAttribute()
    {
        if ($this->route_name) {
            return route($this->route_name);
        }
        return $this->url;
    }

    public function getPlanTypesAttribute()
    {
        return $this->settings['plan_types'] ?? [];
    }

    public function setPlanTypesAttribute($value)
    {
        $settings = $this->settings ?? [];
        $settings['plan_types'] = $value;
        $this->settings = $settings;
    }
}
