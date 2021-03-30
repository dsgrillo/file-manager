<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewFileRequest;
use App\Models\File;
use Illuminate\Http\Response;

class FileController extends Controller
{
    public function newFile(NewFileRequest $request)
    {
        $fileModel = new File();
        $fileModel->fill($request->all());
        $fileModel->user_id = $request->user()->id;
        $fileModel->save();

        return response('', 201);
    }

    public function listFiles()
    {
        return File::all();
    }
}
