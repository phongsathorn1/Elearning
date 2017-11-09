<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Assignment;

class AssignmentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view($classroom_id, $assignment_id)
    {
        return $assignment_id;
    }
    public function store(Request $request)
    {
        $classroom_id = $request->session()->get('classroom_id');
        Assignment::create([
            'user_id' => Auth::id(),
            'classroom_id' => $classroom_id,
            'title' => $request->title,
            'detail' => $request->detail,
            'due_time' => null
        ]);

        return back();
    }
}
