<?php

use App\Http\Controllers\ApplicantController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DateController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Models\Applicant;

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

Route::prefix('main')->group(function () {
    Route::get('application-form', [ApplicantController::class, 'applicationForm'])->name('applicant.application-form');
    Route::post('store-application', [ApplicantController::class, 'storeApplication'])->name('applicant.application.store');
    Route::patch('update-application/{id}', [ApplicantController::class, 'updateApplication'])->name('applicant.application.update');

    Route::get('documents-form', [ApplicantController::class, 'documentsForm'])->name('applicant.documents-form');
    Route::post('store-document/{type}', [ApplicantController::class, 'storeDocument'])->name('applicant.document.store')
        ->where(
            'type',
            strtolower(
                join('|', array_keys(ApplicantController::documentTypes()))
            )
        );
    Route::get('download-cv', [ApplicantController::class, 'downloadCV'])->name('applicant.download-cv');
});

Route::prefix('admin')->group(function () {
    // Dates
    Route::prefix('dates')->group(function () {
        Route::get('/', [DateController::class, 'index'])->name('admin.date');
        Route::post('/', [DateController::class, 'add'])->name('admin.date.add');
        Route::delete('/{id}', [DateController::class, 'destroy'])->name('admin.date.delete');
    });

    Route::prefix('schedules')->group(function () {
        Route::get('/select-schedule', [ScheduleController::class, 'index'])->name('admin.select.schedule');
        Route::post('/select-schedule', [ScheduleController::class, 'select'])->name('admin.select.schedule.update');
    });

    Route::prefix('questions')->group(function () {
        Route::get('/', [QuestionController::class, 'index'])->name('admin.question');
        Route::post('/get-question', [QuestionController::class, 'getQuestionByDept'])->name('admin.question.get');
        Route::post('/add-question', [QuestionController::class, 'addQuestion'])->name('admin.question.add');
        Route::post('/delete-question', [QuestionController::class, 'deleteQuestion'])->name('admin.question.delete');
        Route::post('/update-question', [QuestionController::class, 'updateQuestion'])->name('admin.question.update');
    });

    Route::prefix('interview')->group(function () {
        Route::get('/{applicant_id}/page/{page}', [AnswerController::class, 'getQuestion'])->name('admin.interview');
        Route::post('/submit-answer', [AnswerController::class, 'submitAnswer'])->name('admin.interview.submit.answer');
        Route::post('/submit-score', [AnswerController::class, 'submitScore'])->name('admin.interview.submit.score');
        Route::post('/update-answer', [AnswerController::class, 'updateAnswer'])->name('admin.interview.update.answer');
        Route::post('/update-score', [AnswerController::class, 'updateScore'])->name('admin.interview.update.score');
        Route::post('/add-project', [AnswerController::class, 'addProject'])->name('admin.interview.add.project');
        Route::post('/finish', [AnswerController::class, 'finish'])->name('admin.interview.finish');
    });
});
