<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopList extends Model
{
    protected $fillable = [
        'group_id', 'name', 'status'
    ];

    protected $hidden = [
        'products'
    ];

    public function products(): HasMany{
        return $this->hasMany(Product::class)->orderBy('shop_id')->orderBy('category_id');
    }

    public function group():BelongsTo{
        return $this->belongsTo(Group::class);
    }
}
