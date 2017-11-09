<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Classroom;

class ClassroomController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $classrooms = Classroom::get();
        return view('classroom.home', ['classrooms' => $classrooms]);
    }

    public function view(Request $request, $classroom_id)
    {
        if(Classroom::find($classroom_id)){
            $request->session()->put('classroom_id', $classroom_id);
            $classroom = Classroom::find($classroom_id);
            $posts = $classroom->posts;
            $assignments = $classroom->assignments;
            $posts = $posts->merge($assignments);
            $posts = $posts->sortBy(function ($post){
                return $post->created_at;
            });

            return view('classroom.view', ['classroom' => $classroom, 'posts' => $posts]);
        }
        else
        {
            abort(404);
        }
    }

    public function add()
    {
        return view('classroom.create');
    }

    public function create(Request $request)
    {
        Classroom::create([
            'user_id' => Auth::id(),
            'name' => $request->classroom_name,
            'description' => $request->classroom_description
        ]);

        return redirect()->home();
    }
}
