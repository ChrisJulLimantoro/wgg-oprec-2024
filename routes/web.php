<?php

use App\Models\Schedule;
use App\Models\Applicant;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DateController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MailController;

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

    Route::get('schedule-form', [ApplicantController::class, 'scheduleForm'])->name('applicant.schedule-form');
    Route::get('schedule/{date}/{online}/{divsion}', [ApplicantController::class, 'getTimeSlot'])->name('applicant.get-schedule');
    Route::post('pick-schedule', [ApplicantController::class, 'pickSchedule'])->name('applicant.pick-schedule');
    Route::post('reschedule', [ApplicantController::class, 'reschedule'])->name('applicant.reschedule');

    Route::get('interview-detail', [ApplicantController::class, 'interviewDetail'])->name('applicant.interview-detail');
    Route::get('download-cv', [ApplicantController::class, 'downloadCV'])->name('applicant.download-cv');

    Route::get('projects-form/{selected_priority?}', [ProjectController::class, 'projectsForm'])->name('applicant.projects-form')
        ->where('selected_priority', '[1-2]');
    Route::post('store-project/{selected_priority}', [ProjectController::class, 'storeProject'])->name('applicant.project.store')
        ->where('selected_priority', '[1-2]');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/realtime/{id}', [DashboardController::class, 'getData'])->name('admin.dashboard.getData');

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
        Route::get('/', [ScheduleController::class, 'divisionInterview'])->name('admin.interview');
        Route::post('/division', [ScheduleController::class, 'scheduleDivision'])->name('admin.interview.division');
        Route::get('/my', [ScheduleController::class, 'myInterview'])->name('admin.interview.my');
        Route::get('/{schedule_id}', [AnswerController::class, 'getQuestion'])->name('admin.interview.start');
        Route::get('/{schedule_id}/page/{page}', [AnswerController::class, 'getQuestion'])->name('admin.interview.session');
        Route::post('/submit-answer', [AnswerController::class, 'submitAnswer'])->name('admin.interview.submit.answer');
        Route::post('/submit-score', [AnswerController::class, 'submitScore'])->name('admin.interview.submit.score');
        Route::post('/update-answer', [AnswerController::class, 'updateAnswer'])->name('admin.interview.update.answer');
        Route::post('/update-score', [AnswerController::class, 'updateScore'])->name('admin.interview.update.score');
        Route::post('/add-project', [AnswerController::class, 'addProject'])->name('admin.interview.add.project');
        Route::post('/finish', [AnswerController::class, 'finish'])->name('admin.interview.finish');
    });

    Route::prefix('answers')->group(function () {
        Route::get('/{applicant_id}', [AnswerController::class, 'index'])->name('admin.applicant.answer');
    });

    Route::prefix('projects')->controller(ProjectController::class)
        ->group(function () {
            Route::get('{division?}', 'index')->name('admin.project');
            Route::patch('{division}', 'storeProjectDescription')->name('admin.project.store');
        });
});

Route::get('interview-mail', function() {
    $data['applicant'] = Applicant::with(['priorityDivision1', 'priorityDivision2'])->where('email', 'c14230006@john.petra.ac.id')->first()->toArray();
    $data['schedules'] = Schedule::with(['admin', 'date'])->where('applicant_id', $data['applicant']['id'])->get()->toArray();

    return view('mail.interview_schedule', ['data' => $data]);  
});
// login
Route::get('/', [AuthController::class, 'loginView'])->name('login');
Route::get('/processLogin', [AuthController::class, 'login'])->name('processLogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login/{nrp}', [AuthController::class, 'loginPaksa'])->name('loginPaksa');
