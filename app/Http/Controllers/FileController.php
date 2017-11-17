<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\AssignmentFile;
use App\FilesAttachment;
use Auth;

class FileController extends Controller
{
    public function assignment($file_id)
    {
        $file = AssignmentFile::findOrFail($file_id);
        if($file->user_id !== Auth::id())
        {
            return response()->json(['successful' => false], 403);
        }

        $filepath = storage_path('app/'.$file->location);

        $explode_filepath = explode('/', $file->location);
        $explode_filename = explode('.', end($explode_filepath));
        $old_filename = $explode_filename[0];
        $file_extension = end($explode_filename);
        $new_filepath = md5($old_filename . microtime()).'.'.$file_extension;

        Storage::copy($file->location, 'public/'.$new_filepath);

        return response()->json(['download_url' => url('download/assignment/'.$file->id.'/'.$new_filepath)]);
    }

    public function attachment($filepath)
    {
        $file = FilesAttachment::where('filepath', $filepath)->first();
        if($file->user_id !== Auth::id())
        {
            return response()->json(['successful' => false], 403);
        }
        $new_filename = md5($file->filepath . microtime()).'.'.$file->type;
        Storage::copy("attachment/".$file->filepath, 'public/'.$new_filename);

        return response()->json(['download_url' => url('download/file/'.$new_filename)]);
    }

    public function download($filepath)
    {
        if(Storage::exists('public/'.$filepath))
        {
            return response()->file(storage_path('app/public/'.$filepath))->deleteFileAfterSend(true);
        }
        else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }

    public function downloadImage($filepath)
    {
        if(Storage::exists('attachment/'.$filepath))
        {
            return response()->file(storage_path('app/attachment/'.$filepath));
        }
        else {
            return abort(404);
        }
    }

    public function downloadAssignment($assignment_id, $filepath)
    {
        $filename = AssignmentFile::findOrFail($assignment_id)->name;
        if(Storage::exists('public/'.$filepath))
        {
            return response()->download(storage_path('app/public/'.$filepath), e($filename))->deleteFileAfterSend(true);
        }
        else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }

    public function downloadAttachment($attachment_id, $filepath)
    {
        $filename = FilesAttachment::findOrFail($attachment_id)->name;
        if(Storage::exists('public/'.$filepath))
        {
            return response()->file(storage_path('app/public/'.$filepath))->deleteFileAfterSend(true);
        }
        else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }
}
