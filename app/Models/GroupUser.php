<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupUser extends Model
{
    protected $fillable = [
        'group_id', 'user_id',
    ];

    protected $appends = [
        'name', 'email'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo{
        return $this->belongsTo(Group::class);
    }

    public function getNameAttribute(){
        return $this->user->name;
    }

    public function getEmailAttribute(){
        return $this->user->email;
    }
}
