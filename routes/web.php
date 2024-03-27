<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;


Route::get('/', function () {
    return view('welcome');
});
Route::resource('tasks', TaskController::class);
Route::get('/tasks/get-attachment-url/{filename}', [TaskController::class, 'getImageURL']);
// Route::get('/download-file/{filename}', [TaskController::class, 'downloadFile']);

