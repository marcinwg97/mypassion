<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostFavorite extends Model
{

    protected $fillable = ['post_id', 'user_id'];

    public function post()
    {
        return $this->hasOne('App\Models\Post', 'id', 'post_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

}