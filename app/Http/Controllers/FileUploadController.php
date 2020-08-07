<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class FileUploadController extends Controller
{
    public function fileUploadPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:20480',
            'notes' => 'required|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $data = $request->input();
        $imageName = time() . '.' . $request->file->extension();
        $data['uploader_id'] = auth()->user()->id;
        $data['file'] = $imageName;

        $file = File::create($data);

        if ($file) {
            $request->file->move(public_path('uploads'), $imageName);
            return response()->json($file->load('uploader'), 200);
        }
    }

    public function destroy(File $file)
    {
        if (file_exists(public_path('uploads/' . $file->file))) {
            unlink(public_path('uploads/' . $file->file));
        }
        $file->delete();

        return response()->json('Archivo eliminado del sistema', 200);
    }

    public function download(File $file)
    {
        Gate::authorize('download-file', $file);
        if (file_exists(public_path('uploads/' . $file->file))) {
            $filePath = public_path('uploads/' . $file->file);
            return response()->download($filePath);
        }
        return redirect()->back();
    }
}
