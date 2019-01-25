<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryProduct extends Model
{
    protected $fillable = [
        'category_id', 'name'
    ];

    protected $appends = [
        'unit_type', 'category_name'
    ];

    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function getUnitTypeAttribute(){
        return $this->category->unit_type;
    }

    public function getCategoryNameAttribute(){
        return $this->category->name;
    }

}
