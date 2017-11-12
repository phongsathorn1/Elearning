<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Classroom;
use App\Assignment;
use App\AssignmentFile;
use App\AssignmentCheck;

class AssignmentController extends Controller
{
    public function show($classroom_id, $id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        $assignment = Assignment::findOrFail($id)->load('user');
        $files = AssignmentFile::where([
            ['user_id', Auth::id()],
            ['assignment_id', $id]
        ])->get();

        return response()->json(['assignment' => $assignment, 'uploaded_files' => $files]);
    }

    public function store(Request $request, $classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        Assignment::create([
            'user_id' => Auth::id(),
            'classroom_id' => $classroom_id,
            'title' => $request->title,
            'detail' => $request->detail,
            'due_time' => $request->duetime
        ]);

        return response()->json(['sucessful' => true]);
    }

    public function upload(Request $request, $classroom_id, $id)
    {
        Classroom::findOrFail($classroom_id);
        $original_name = $request->file->getClientOriginalName();
        $file = $request->file('file')->store('file');

        $file = AssignmentFile::create([
            'user_id' => Auth::id(),
            'assignment_id' => $id,
            'name' => $original_name,
            'location' => $file
        ]);

        return response()->json($file);
    }

    public function removeFile(Request $request, $classroom_id, $id)
    {
        Classroom::findOrFail($classroom_id);
        $file = AssignmentFile::findOrFail($request->file_id);
        if($file->user_id == Auth::id()){
            Storage::delete($file->location);
            $file->delete();
        }
        else
        {
            return response()->json(['sucessful' => false], 403);
        }

        return response()->json(['sucessful' => true]);
    }

    public function confirm(Request $request, $classroom_id, $id){
        Classroom::findOrFail($classroom_id);
        if(AssignmentCheck::where([
            ['user_id', Auth::id()],
            ['assignment_id', $id]
        ])->exists())
        {
            return response()->json(['error' => 'this student already sent.'], 403);
        }

        AssignmentCheck::create([
            'user_id' => Auth::id(),
            'assignment_id' => $id,
            'score' => 0,
            'returned' => false
        ]);

        return response()->json(['successful' => true]);
    }

    public function alldone($classroom_id, $id)
    {
        Classroom::findOrFail($classroom_id);
        $all = AssignmentCheck::where('assignment_id', $id)->get()->load('files', 'user');

        return response()->json($all);
    }
}
