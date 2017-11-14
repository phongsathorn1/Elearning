<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Classroom;
use App\Assignment;
use App\AssignmentFile;
use App\AssignmentCheck;
use Carbon\Carbon;

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
        $status = AssignmentCheck::where([
            ['user_id', Auth::id()],
            ['assignment_id', $id]
        ]);
        $is_done = $status->exists();

        return response()->json([
            'assignment' => $assignment,
            'uploaded_files' => $files,
            'is_done' => $is_done,
            'status' => $status->first()
        ]);
    }

    public function store(Request $request, $classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        Assignment::create([
            'user_id' => Auth::id(),
            'classroom_id' => $classroom_id,
            'title' => $request->title,
            'detail' => $request->detail,
            'due_time' => $request->duetime,
            'score' => $request->score
        ]);

        return response()->json(['sucessful' => true]);
    }

    public function upload(Request $request, $classroom_id, $id)
    {
        Classroom::findOrFail($classroom_id);
        
        $assignment = Assignment::findOrFail($id);
        $now = Carbon::now();
        $due = Carbon::createFromFormat("Y-m-d H:i:s", $assignment->due_time);
        if($due->lte($now)){
            return response()->json(['error' => 'This assignment time up!'], 403);
        }

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

        $assignment = Assignment::findOrFail($id);
        $now = Carbon::now();
        $due = Carbon::createFromFormat("Y-m-d H:i:s", $assignment->due_time);
        if($due->lte($now)){
            return response()->json(['error' => 'This assignment time up!'], 403);
        }

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

        $assignment = Assignment::findOrFail($id);
        $now = Carbon::now();
        $due = Carbon::createFromFormat("Y-m-d H:i:s", $assignment->due_time);
        if($due->lte($now)){
            return response()->json(['error' => 'This assignment time up!'], 403);
        }

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

    //for teacher give them score
    public function update(Request $request, $classroom_id, $id)
    {
        Classroom::findOrFail($classroom_id);
        $assignment = AssignmentCheck::where([
            ['assignment_id', $id],
            ['user_id', $request->user_id]
        ])->first();
        $assignment->returned = true;
        $assignment->comment = $request->comment;
        $assignment->score = $request->score;
        $assignment->save();

        return response()->json(['successful' => true]);
    }
}
