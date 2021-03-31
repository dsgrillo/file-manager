<?php

namespace App\Services;

use App\Models\File;
use App\Models\User;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class FileService
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function saveFile($fileName, \Illuminate\Http\File $fileUploaded)
    {
        $originalPath = Storage::put($this->getBasePath(), $fileUploaded);

        $model = new File();
        $model->name = $fileName;
        $model->path = $originalPath;
        $model->extension = $fileUploaded->extension();
        $model->size = $fileUploaded->getSize();
        $model->user_id = $this->user->id;
        $model->save();

        return $model;
    }

    public function downloadFile($fileId)
    {
        $model = $this->getFile($fileId);

        return Storage::download($model->path, $model->name . $model->extension);
    }

    public function rename($fileId, $newName)
    {
        $model = $this->getFile($fileId);

        $model->name = $newName;
        $model->save();
    }

    public function getBasePath()
    {
        return "user_{$this->user->id}";
    }

    private function getFile($fileId)
    {
        $model = File::find($fileId);

        if ($model === null) {
            throw new FileNotFoundException("File not found.");
        }

        if ($model->user->id !== $this->user->id) {
            throw new FileNotFoundException("Unauthorized access");
        }

        return $model;
    }
}
