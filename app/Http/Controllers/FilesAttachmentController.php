<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\FilesAttachment;
use Auth;

class FilesAttachmentController extends Controller
{
    public function upload(Request $request)
    {
        $original_name = $request->file->getClientOriginalName();
        $file = $request->file('file')->store('attachment');
        $extension = $request->file->extension();

        $file = FilesAttachment::create([
            'user_id' => Auth::id(),
            'name' => $original_name,
            'type' => $extension,
            'filepath' => basename($file)
        ]);

        return response()->json(['filename' => $file->filepath, 'name' => $original_name]);
    }
}
