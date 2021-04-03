<?php


namespace App\Http\Livewire;


use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

abstract class BaseComponent extends Component
{
    protected function service()
    {
        return new FileService(Auth::user());
    }

}
