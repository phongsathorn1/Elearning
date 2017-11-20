<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email'
        ]);

        $me = Auth::user();

        if(User::where('username', $request->username)->get() &&
        Auth::user()->username != $request->username)
        {
            $errors = [
                'errors' => [
                    "username" => ['Username is already exist.']
                ]
            ];
            return response()->json($errors, 403);
        }

        if(User::where('email', $request->email)->get() &&
        Auth::user()->email != $request->email)
        {
            $errors = [
                'errors' => [
                    "email" => ['Email is already exist.']
                ]
            ];
            return response()->json($errors, 403);
        }

        $me->name = $request->name;
        $me->username = $request->username;
        $me->email = $request->email;
        $me->save();

        return response()->json(['success' => true]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if(!Hash::check($request->password, Auth::user()->password))
        {
            $errors = [
                'errors' => [
                    "password" => ['Incorrect password']
                ]
            ];
            return response()->json($errors, 403);
        }

        $me = Auth::user();
        $me->password = bcrypt($request->newpassword);
        $me->save();

        return response()->json(['success' => true]);
    }
}
