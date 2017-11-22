<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\User;
use App\Role;

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

    public function uploadProfile(Request $request)
    {
        $request->validate([
            'file' => 'image|required'
        ]);

        $user = Auth::user();
        $file = $request->file('file')->store('avatar/'.$user->id);

        $uploaded_name = trim(basename($file));
        $user->avatar = $uploaded_name;
        $user->save();

        return response()->json(['success' => true, 'avatar_url' => url('avatar/'.$user->id.'/'.$uploaded_name)]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:60',
            'surname' => 'required|max:60',
            'username' => 'required|max:191|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'role_id' => 'required|numeric',
        ]);

        $filename = null;
        if(strlen($request->avatar_url) > 0){
            $filename = basename($request->avatar_url);
        }

        if(!Role::find($request->role_id)){
            return response()->json(['success' => 'false'], 403);
        }

        $user = User::create([
            'name' => $request->name." ".$request->surname,
            'username' => $request->username,
            'email' => $request->email,
            'avatar' => $filename,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        if($filename){
            Storage::move('avatar/cache/'.$filename, 'avatar/'.$user->id.'/'.$filename);
        }

        return response()->json(['success' => true]);
    }

    public function uploadTempProfile(Request $request)
    {
        $request->validate([
            'file' => 'image|required'
        ]);

        $file = $request->file('file')->store('avatar/cache');
        $uploaded_name = trim(basename($file));
        return response()->json([
            'success' => true,
            'avatar_file' => $uploaded_name,
            'avatar_url' => url('avatar/cache/'.$uploaded_name),
        ]);
    }
}
