<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventContoller;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserEventHandlingController;

// Auth
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'userLogin');
    Route::post('/logout', 'logout')->name('logout');
});

// Dashboard
Route::middleware(['custom.auth'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    // Auth::routes();

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
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
