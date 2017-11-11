<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Post;
use App\User;

class PostController extends Controller
{
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
}
