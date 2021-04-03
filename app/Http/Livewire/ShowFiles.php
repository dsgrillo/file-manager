<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;

class ShowFiles extends BaseComponent
{
    use WithPagination;

    public $isUpdating;
    public $name;

    public function render()
    {
        return view(
            'livewire.show-files',
            [
                'files' => $this->service()->getAll()
            ]
        );
    }

    public function download($id)
    {
        return $this->service()->downloadFile($id);
    }

    public function delete($id)
    {
        $this->service()->delete($id);
    }

    public function setIsUpdating($id, $name)
    {
        $this->cancelUpdate();

        $this->isUpdating = $id;
        $this->name = $name;
    }

    public function updateName($id)
    {
        $this->validate([
            'name' => $this->nameRule($id)
        ]);

        $this->service()->rename($id, $this->name);
        $this->cancelUpdate();
    }

    public function cancelUpdate()
    {
        $this->name = false;
        $this->isUpdating = false;

        $this->resetErrorBag();
        $this->resetValidation();
    }
}
