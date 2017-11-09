<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $classroom_id = $request->session()->get('classroom_id');
        Post::create([
            'user_id' => Auth::id(),
            'classroom_id' => $classroom_id,
            'type' => 'post',
            'detail' => $request->post
        ]);

        return redirect()->route('classroom.view', ['classroom_id' => $classroom_id]);
    }
}
