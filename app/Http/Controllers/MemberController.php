<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;

class MemberController extends Controller
{
    public function show($classroom_id){
        $members = Classroom::find($classroom_id)->members->load('role');

        return response()->json($members);
    }
}
