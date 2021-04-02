<?php

namespace App\Http\Livewire;

use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowFiles extends Component
{
    use WithFileUploads;

    public $isOpen = false;
    public $fileName;
    public $file;
    public $iteration = 0;

    private function service()
    {
        return new FileService(Auth::user());
    }

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
        $this->closeModal();
    }

    private function clearInputs()
    {
        $this->file = null;
        $this->fileName = null;
        $this->iteration++;
    }

    public function create()
    {
        $this->openModal();
    }

    public function delete($id)
    {
        $this->service()->delete($id);
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->clearInputs();
    }
}
