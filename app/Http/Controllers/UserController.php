<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $me = User::findOrFail(Auth::id())->load('role');
        $me->role->makeVisible('actions');

        return response()->json($me);
    }
}
