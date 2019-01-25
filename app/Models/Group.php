<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Group extends Model
{
    protected $fillable = [
        'name', 'owner_id',
    ];



    public function owner(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function isOwner(){
        $user = Auth::Guard('api')->user();
        return $this->owner_id == $user->id;
    }

    public function shops(): HasMany{
        return $this->hasMany(Shop::class);
    }

    public function users(): HasMany{
        return $this->hasMany(GroupUser::class);
    }

    public function deleteGroup(){

    }
}
