<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventContoller;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserEventHandlingController;
use Illuminate\Support\Facades\Auth;

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/', function () {
    if (Auth::guest()) {
        return redirect()->route('login');
    } else {
        return redirect()->route('dashboard');
    }
});

// Dashboard
Route::middleware(['web'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    Route::controller(EventContoller::class)->group(function () {
        Route::get('/create', 'create')->name('event.create');
        Route::post('/store', 'store');
        Route::get('/list', 'index')->name('event.list');
        // Route::post('event/edit', 'edit');
        Route::get('event/edit/{id}', 'edit')->name('event.edit');
        Route::get('event/show/{id}', 'show')->name('event.show');
        Route::post('event/delete', 'delete');
        Route::post('personal/info/delete', 'PersonalInfodelete');
        Route::post('event/update/{id}', 'update')->name('event.update');
        Route::get('question/list/{id}', 'questionList')->name('question.list');
        Route::post('question/update', 'questionUpdate');
        Route::post('question/delete', 'questionDelete');
    });
});
Route::controller(UserEventHandlingController::class)->group(function () {
    Route::get('user/event/{id}', 'index')->name('user.event.form');
    Route::post('user/event/store', 'eventDataStore');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');