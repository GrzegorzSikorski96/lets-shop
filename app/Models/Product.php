<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'list_id', 'name', 'category_id', 'status', 'shop_id'
    ];

    protected $appends = [
        'unit_type'
    ];

    public function shopList(): BelongsTo{
        return $this->belongsTo(ShopList::class);
    }

    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function shop(): HasOne{
        return $this->hasOne(Shop::class);
    }

    public function getUnitTypeAttribute(){
        if(($category = $this->category) == null) return null;
        return $category->unit_type;
    }

}