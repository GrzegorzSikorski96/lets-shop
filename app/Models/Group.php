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

    protected $hidden = [
        'shop_lists'
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

    public function shopLists(): HasMany{
        return $this->hasMany(ShopList::class);
    }

    public function findUser($id){
        return $this->users->where('user_id', $id)->first() != null;
    }

    public function deleteGroup(){


        foreach($this->users as $group_user){
            $group_user->delete();
        }

        foreach($this->shopLists as $list){
            foreach($list->products as $product){
                $product->delete();
            }
            $list->delete();
        }

        foreach($this->shops as $shop){
            $shop->delete();
        }

        $this->delete();
    }
}
