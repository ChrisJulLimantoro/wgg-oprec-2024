<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DateController;
use App\Http\Controllers\ScheduleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function(){
    // Dates
    Route::prefix('dates')->group(function(){
        Route::get('/', [DateController::class, 'index'])->name('admin.date');
        Route::post('/', [DateController::class, 'add'])->name('admin.date.add');
        Route::delete('/{id}', [DateController::class, 'destroy'])->name('admin.date.delete');
    });

    Route::prefix('schedules')->group(function(){
        Route::get('/select-schedule', [ScheduleController::class, 'index'])->name('admin.select.schedule');
        Route::post('/select-schedule', [ScheduleController::class, 'select'])->name('admin.select.schedule.update');
    });
});