<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{

    protected $fillable = ['favorite_user_id', 'user_id'];

    public function favorite_user()
    {
        return $this->hasOne('App\Models\User', 'id', 'favorite_user_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

}