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
Route::middleware(['auth'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('dashboard/count', 'counts')->name('dashboard.counts');
    });

    Route::prefix('event')
        ->as('event.')
        ->group(function () {
            Route::get('/create', [EventContoller::class, 'create'])->name('create');
            Route::post('/store', [EventContoller::class, 'store'])->name('store');
            Route::get('/list', [EventContoller::class, 'index'])->name('index');
            Route::get('event/edit/{id}', [EventContoller::class, 'edit'])->name('edit');
            Route::get('event/show/{id}', [EventContoller::class, 'show'])->name('show');
            Route::post('event/delete', [EventContoller::class, 'delete'])->name('delete');
            Route::post('personal/info/delete', [EventContoller::class, 'PersonalInfodelete']);
            Route::post('event/update/{id}', [EventContoller::class, 'update'])->name('update');
            Route::get('question/list/{id}', [EventContoller::class, 'questionList'])->name('question.list');
            Route::post('question/update', [EventContoller::class, 'questionUpdate']);
            Route::post('question/delete', [EventContoller::class, 'questionDelete']);
            Route::get('event/set-correct-answer/{id}', [EventContoller::class, 'setCorrectAnswer'])->name('set-correct-answer');
            Route::post('event/set-correct-answer/{id}', [EventContoller::class, 'saveCorrectAnswer'])->name('save-correct-answer');
            Route::post('event/change-status/{id}', [EventContoller::class, 'changeStatus'])->name('change-status');
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
