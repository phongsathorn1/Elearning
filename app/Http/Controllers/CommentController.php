<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Comment;
use App\Post;

class CommentController extends Controller
{
    public function show($post_id)
    {
        $comments = Post::findOrFail($post_id)->comments;

        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        $post = Post::findOrFail($request->post_id);
        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);

        return response()->json($comment->load('user'));
    }
}
