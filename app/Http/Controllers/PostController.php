<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Post;
use App\User;

class PostController extends Controller
{
    public function show($post_id)
    {
        $post = Post::findOrFail($post_id);
        if(Auth::user()->classroom->find($post->classroom_id)->exists())
        {
            return response()->json($post);
        }
        else{
            return response()->json(['success' => false], 403);
        }
    }
    public function store(Request $request)
    {
        Post::create([
            'user_id' => Auth::id(),
            'classroom_id' => $request->classroom_id,
            'type' => 'post',
            'detail' => $request->post
        ]);

        return response()->json([
            'successful' => true
        ]);
    }

    public function update(Request $request, $post_id)
    {
        $post = Post::findOrFail($post_id);
        if($post->user_id == Auth::id())
        {
            $post->detail = $request->post;
            $post->save();

            return response()->json(['success' => true]);
        }
        else{
            return response()->json(['success' => false], 403);
        }
    }
}
