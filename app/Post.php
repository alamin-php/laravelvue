<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
      'category_id','comment_id','tag_id','user_id','title','body','photo',
    ];

	public function user(){
	    return $this->belongsTo('App\User');
	}	

	public function category(){
	    return $this->belongsTo('App\Category');
	}	

	public function comments(){
	    return $this->belongsTo('App\Comment', 'comment_id');
	}
}
