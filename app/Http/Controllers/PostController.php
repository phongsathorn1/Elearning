<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Post;
use App\User;
use App\FilesAttachment;

class PostController extends Controller
{
    public function show($post_id)
    {
        $post = Post::findOrFail($post_id);
        if(Auth::user()->classroom->find($post->classroom_id))
        {
            $posts = $posts->load('user', 'comments', 'attachments', 'comments.user', 'assignment');
            $posts = $posts->each(function ($item, $key){
                if(!$item->assignment){
                    $item->makeHidden('assignment');
                }
                if(!$item->attachments->count()){
                    $item->makeHidden('attachments');
                }
            });
            return response()->json($post);
        }
        else{
            return response()->json(['success' => false], 403);
        }
    }
    public function store(Request $request)
    {
        $post = Post::create([
            'user_id' => Auth::id(),
            'classroom_id' => $request->classroom_id,
            'type' => 'post',
            'detail' => $request->post
        ]);

        foreach($request->get('files') as $file){
            FilesAttachment::where('filepath', $file['filename'])->first()->posts()->attach($post->id);
        }

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

    public function destroy($post_id)
    {
        $post = Post::findOrFail($post_id);
        if(Auth::user()->post->find($post_id))
        {
            $post->delete();

            return response()->json(['success' => true]);
        }
        else{
            return response()->json(['success' => false], 403);
        }
    }
}
