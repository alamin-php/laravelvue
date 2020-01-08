<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Auth;
use App\Post;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::with('category','user')->latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
           $post = new Post;
           $post->title = $request->title;
           $post->body = $request->body;
           $post->category_id = $request->category_id;
           //it will store the current logged in user id in user_id field
           $post->user_id = Auth::user()->id;
           $post->save();

        // return Post::create([
        //     'title' => $request['title'],
        //     'body' => $request['body'],
        //     'category_id' => $request['category_id'],
        //     'user_id' => Auth::user()->id,
        // ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('category','comments','user')->findOrfail($id);
        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrfail($id);

        $post->update($request->all());

        return ['message' => '200 OK'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrfail($id);
        $post->delete();
        return ['message' => '200 OK'];
    }
}
