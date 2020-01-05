<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
      'details',
    ];

    public function posts(){
        return $this->hasMany('App\Post');
    }
}
