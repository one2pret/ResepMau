<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\PostTransformer;
use App\Post;
use App\User;
use Auth;

class PostController extends Controller
{
    public function show(){
      $posts = Post::orderBy('id','DESC')->get();

      $response = fractal()
        ->collection($posts)
        ->transformWith(new PostTransformer)
        ->toArray();

      return response()->json($response,200);

    }

    public function store(Request $request, Post $post){
      $this->validate($request, [
        'title'      => 'required|min:5',
        'content'  => 'required|min:10',
      ]);

      $post = $post->create([
        'user_id'   => Auth::user()->id,
        'title'     => $request->title,
        'content'   => $request->content,
      ]);

      // $response = fractal()
      //   ->item($post)
      //   ->transformWith(new PostTransformer)
      //   ->toArray();

        return response()->json([
          'Message' => 'Post Created'
        ], 201);
    }

    public function update(Request $request, $id){

      $post = Post::find($id);
      $post->update([
        'title'     => $request->title,
        'content'   => $request->content,
      ]);

      return response()->json([
        'Message' => 'Post Updated'
      ], 201);
    }

    public function destroy(Post $post){
      $post->delete();

      return response()->json([
        'Message' => 'Post Deleted',
      ]);
    }

    // public function getPostUser(){
    //   $post = Post::where('user_id', Auth::user()->id)->orderBy('id','DESC')->get();
    //
    //   $response = fractal()
    //     ->item($post)
    //     ->transformWith(new PostTransformer)
    //     ->toArray();
    //
    //   return response()->json($response, 200);
    // }

    
}
