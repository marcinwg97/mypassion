<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Category extends Model
    {

        protected $fillable = ['name'];

        public function post()
        {
            return $this->belongsTo('App\Models\Post', 'category_id');
        }

        public function event()
        {
            return $this->belongsTo('App\Models\Event', 'category_id');
        }
    }
