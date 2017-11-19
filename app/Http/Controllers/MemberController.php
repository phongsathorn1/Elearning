<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;
use App\User;
use Auth;

class MemberController extends Controller
{
    public function index(){
        $users = User::get()->load('role');

        return response()->json($users);
    }

    public function show($classroom_id){
        $members = Classroom::findOrFail($classroom_id)->members->load('role');

        if(!$members->find(Auth::id())){
            return response()->json(['error' => "You don't have permission to access this."], 403);
        }

        return response()->json($members);
    }

    public function add(Request $request){
        $classroom = Classroom::findOrFail($request->classroom_id);
        if(!$classroom->members->contains($request->user_id))
        {
            $classroom->members()->attach($request->user_id);
            return response()->json($classroom);
        }

        return response()->json(['error' => 'this user already member of this classroom'], 403);
    }

    public function remove(Request $request){
        $classroom = Classroom::findOrFail($request->classroom_id);
        if($classroom->members->contains($request->user_id))
        {
            $classroom->members()->detach($request->user_id);
            return response()->json($classroom);
        }

        return response()->json(['error' => "this user isn't member of this classroom"], 403);
    }
}
