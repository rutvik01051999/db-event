<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventContoller;
use App\Http\Controllers\UserEventHandlingController;
 
// Route::get('/login2', function () {
//     return view('welcome');
// });

Auth::routes();

Route::controller(EventContoller::class)->group(function () {
    Route::get('/create', 'create');
    Route::post('/store', 'store');
    Route::get('/list', 'index')->name('event.list');
    Route::post('event/edit', 'edit');
    Route::post('event/delete', 'delete');
    Route::post('event/update', 'update');
    Route::get('question/list/{id}', 'questionList');
});

Route::controller(UserEventHandlingController::class)->group(function () {
    Route::get('{id}', 'index');
});




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
