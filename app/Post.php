<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
      'category_id','comment_id','tag_id','user_id','title','body','photo',
    ];
}
