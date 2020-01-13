<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){
    	return view('public/index');
    }    

    public function getPost(){
    	return Post::all();
    }
}
