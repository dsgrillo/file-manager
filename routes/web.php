<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\FileController;
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
    Route::get('/list', [FileController::class, 'listFiles'])->name('file.list');
    Route::post('/new', [FileController::class, 'newFile'])->name('file.new');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



require __DIR__.'/auth.php';
