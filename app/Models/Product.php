<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'shop_list_id', 'name', 'category_id', 'status', 'shop_id', 'description', 'count'
    ];
    public $timestamps = false;
    protected $appends = [
        'unit_type', 'category_name', 'shop_name'
    ];

    public function shopList(): BelongsTo
    {
        return $this->belongsTo(ShopList::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function getUnitTypeAttribute()
    {
        if (($category = $this->category) == null) return null;
        return $category->unit_type;
    }

    public function getCategoryNameAttribute()
    {
        if (($category = $this->category) == null) return null;
        return $category->name;
    }

    public function getShopNameAttribute()
    {
        if (($shop = $this->shop) == null) return null;
        return $shop->name;
    }
}