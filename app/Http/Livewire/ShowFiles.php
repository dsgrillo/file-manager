<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;

class ShowFiles extends BaseComponent
{
    use WithPagination;

    public $fileName;
    public $file;

    public function render()
    {
        return view(
            'livewire.show-files',
            [
                'files' => $this->service()->getAll()
            ]
        );
    }

    public function save()
    {
        $this->validate([
            'fileName' => 'required|max:255',
            'file' => 'required|max:8192'
        ]);

        $this->service()->saveFile($this->fileName, $this->file);
    }

    public function delete($id)
    {
        $this->service()->delete($id);
    }
}
