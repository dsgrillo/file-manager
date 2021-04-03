<?php


namespace App\Http\Livewire;

use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

abstract class BaseComponent extends Component
{
    protected function service()
    {
        return new FileService(Auth::user());
    }

    public function nameRule($id = null)
    {
        return [
            'required',
            'max:255',
            Rule::unique('files')->where(function ($query) {
                return $query->where('user_id', Auth::user()->id);
            })->ignore($id),
        ];
    }
}
