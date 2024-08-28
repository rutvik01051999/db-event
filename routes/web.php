<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventContoller;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Select2Controller;
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
        Route::get('dashboard/count', 'counts')->name('dashboard.counts');
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
        Route::get('event/set-correct-answer/{id}', 'setCorrectAnswer')->name('event.set-correct-answer');
        Route::post('event/set-correct-answer/{id}', 'saveCorrectAnswer')->name('event.save-correct-answer');
        Route::post('event/change-status/{id}', 'changeStatus')->name('event.change-status');
    });
});
Route::controller(UserEventHandlingController::class)->group(function () {
    Route::get('user/event/{id}', 'index')->name('user.event.form');
    Route::post('user/event/store', 'eventDataStore')->name('user.event.submit');
    Route::post('user/event/save-location', 'saveLocation')->name('user.event.save-location');
});

Route::prefix('permission')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/assign', [PermissionController::class, 'assign'])->name('permission.assign');
        Route::post('/store', [PermissionController::class, 'store'])->name('permission.store');
        // permissions.searchByEmployeeId
        Route::post('/search-by-employee-id', [PermissionController::class, 'searchByEmployeeId'])->name('permission.search-by-employee-id');
    });

Route::prefix('report')
    ->as('report.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/event-report', [ReportController::class, 'eventReport'])->name('event');
        Route::post('/event-report/fetch', [ReportController::class, 'fetch'])->name('event.fetch');

        // Export
        Route::post('/event-report/export', [ReportController::class, 'export'])->name('event.export');
    });

// select2.events
Route::prefix('select2')->group(function () {
    Route::get('events', [Select2Controller::class, 'events'])->name('select2.events');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
