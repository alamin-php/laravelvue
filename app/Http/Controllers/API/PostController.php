<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Auth;
use App\Post;
use Image;
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
            $this->middleware('auth:api');
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
        $request->validate([
            'title' => 'required|min:6|max:50',
            'body' => 'required|min:6|string',
        ]);

        $strpos = strpos($request->photo, ';');
        $sub = substr($request->photo, 0, $strpos);
        $ex = explode('/', $sub)[1];
        $name = time().'.'.$ex;
        $img = Image::make($request->photo)->resize(200, 200);
        $path = public_path().'/upload/';
        $img->save($path.$name);

        return Post::create([
            'title' => $request['title'],
            'body' => $request['body'],
            'category_id' => $request['category_id'],
            'user_id' => auth('api')->user()->id,
            'photo' => $name,
        ]);

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
        $post = Post::find($id);

        $request->validate([
            'title' => 'required|min:6|max:50',
            'body' => 'required|min:6|string',
        ]);

        if ($request->photo != $post->photo) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time().'.'.$ex;
            $img = Image::make($request->photo)->resize(200, 200);
            $path = public_path().'/upload/';
            $image = $path.$post->photo;
            $img->save($path.$name);

            if (file_exists($image)) {
                @unlink($image);
            }
        }else{
            $name = $post->photo;
        }

        $post->title = $request->title;
        $post->body = $request->body;
        $post->category_id = $request->category_id;
        $post->user_id = auth('api')->user()->id;
        $post->photo = $name;
        $post->save();

        // if ($request->photo != $post->photo) {
        //     $strpos = strpos($request->photo, ';');
        //     $sub = substr($request->photo, 0, $strpos);
        //     $ex = explode('/', $sub)[1];
        //     $name = time().'.'.$ex;
        //     $img = Image::make($request->photo)->resize(200, 200);
        //     $path = public_path().'/upload/';
        //     $image = $path.$post->photo;
        //     $img->save($path.$name);

        //     if (file_exists($image)) {
        //         @unlink($image);
        //     }else{
        //         $name = $post->photo;
        //     }
        // }
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
        $img_path = public_path().'/upload/';
        $image = $img_path.$post->photo;
        if (file_exists($image)) {
            @unlink($image);
        }
        $post->delete();
        return ['message' => '200 OK'];
    }
}
