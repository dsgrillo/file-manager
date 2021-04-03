<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('register');
});

Route::group(['prefix' => '/app', 'middleware' => 'auth'], function () {
    Route::get('/files', \App\Http\Livewire\ShowFiles::class)->name('file');
});

Route::get('/dashboard', function () {
    return redirect()->route('file');
})->middleware(['auth'])->name('dashboard');



require __DIR__.'/auth.php';
