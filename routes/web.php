<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventContoller;
use App\Http\Controllers\UserEventHandlingController;
 
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::controller(EventContoller::class)->group(function () {
    Route::get('/create', 'create')->name('event.create');
    Route::post('/store', 'store');
    Route::get('/list', 'index')->name('event.list');
    Route::post('event/edit', 'edit');
    Route::post('event/delete', 'delete');
    Route::post('personal/info/delete', 'PersonalInfodelete');
    Route::post('event/update', 'update');
    Route::get('question/list/{id}', 'questionList');
    Route::post('question/update', 'questionUpdate');
    Route::post('question/delete', 'questionDelete');
});

Route::controller(UserEventHandlingController::class)->group(function () {
    Route::get('{id}', 'index');
    Route::post('user/event/store', 'eventDataStore');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
