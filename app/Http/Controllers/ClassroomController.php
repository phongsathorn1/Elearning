<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;
use Auth;

class ClassroomController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    public function index()
    {
        $classrooms = Classroom::get();
        return response()->json($classrooms);
    }

    public function show($classroom_id)
    {
        if(Classroom::find($classroom_id)){
            $classroom = Classroom::find($classroom_id);

            $posts = $classroom->posts->load('user');
            $assignments = $classroom->assignments->load('user');
            $posts = $posts->merge($assignments);
            $posts = $posts->sortByDesc('created_at')->values()->all();

            return response()->json(['classroom' => $classroom, 'posts' => $posts]);
        }
        else
        {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $classroom = Classroom::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description
        ]);

        $classroom->members()->attach(Auth::id());

        return response()->json($classroom);
    }
}
