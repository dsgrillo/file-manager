<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class UploadFile extends BaseComponent
{
    use WithFileUploads;

    public $name;
    public $file;

    public function render()
    {
        return view('livewire.upload-file');
    }
/*
    public function updatedName()
    {
        $this->validate($this->rules());
    }

    public function updatedFile()
    {
        $this->validate($this->rules());
    }
*/
    public function save()
    {
        $this->validate($this->rules());
        $this->service()->saveFile($this->name, $this->file);

        session()->flash('message', 'Your file has been uploaded.');

        return redirect()->route('file');
    }

    private function rules()
    {
        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('files')->where(function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                }),
            ],
            'file' => 'required|max:8192', // 8MB Max
        ];
    }
}
