<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Classroom;
use App\Assignment;

class AssignmentController extends Controller
{
    public function show($classroom_id, $id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        $assignment = Assignment::findOrFail($id)->load('user');

        return response()->json($assignment);
    }

    public function store(Request $request, $classroom_id)
    {
        $classroom = Classroom::findOrFail($request->classroom_id);
        Assignment::create([
            'user_id' => Auth::id(),
            'classroom_id' => $classroom_id,
            'title' => $request->title,
            'detail' => $request->detail,
            'due_time' => $request->duetime
        ]);

        return response()->json(['sucessful' => true]);
    }
}
