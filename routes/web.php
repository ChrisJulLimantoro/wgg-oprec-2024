<?php

use App\Http\Controllers\AdminController;
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
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AssetController;

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

Route::prefix('main')->middleware(['session', 'applicant'])->group(function () {
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
    Route::post('get-schedule', [ApplicantController::class, 'getTimeSlot'])->name('applicant.get-schedule');
    Route::post('pick-schedule', [ApplicantController::class, 'pickSchedule'])->name('applicant.pick-schedule');
    Route::post('reschedule', [ApplicantController::class, 'reschedule'])->name('applicant.reschedule');

    Route::get('interview-detail', [ApplicantController::class, 'interviewDetail'])->name('applicant.interview-detail');
    Route::get('cv', [ApplicantController::class, 'previewCV'])->name('applicant.cv');

    Route::get('projects-form/{selected_priority?}', [ProjectController::class, 'projectsForm'])->name('applicant.projects-form')
        ->where('selected_priority', '[1-2]');
    Route::post('store-project/{selected_priority}', [ProjectController::class, 'storeProject'])->name('applicant.project.store')
        ->where('selected_priority', '[1-2]');
});

Route::prefix('admin')->middleware(['session', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/realtime', [DashboardController::class, 'getData'])->name('admin.dashboard.getData');

    Route::prefix('meeting-spot')->group(function () {
        Route::get('/', [AdminController::class, 'meetingSpot'])->name('admin.meeting-spot');
        Route::patch('/{admin}', [AdminController::class, 'updateMeetSpot'])->name('admin.meeting-spot.update');
    });

    // Dates
    Route::prefix('dates')->group(function () {
        Route::get('/', [DateController::class, 'index'])->name('admin.date');
        Route::post('/', [DateController::class, 'add'])->name('admin.date.add');
        Route::delete('/{id}', [DateController::class, 'destroy'])->name('admin.date.delete');
    });

    Route::prefix('schedules')->group(function () {
        Route::get('/select-schedule', [ScheduleController::class, 'index'])->name('admin.select.schedule');
        Route::patch('/select-schedule', [ScheduleController::class, 'select'])->name('admin.select.schedule.update');
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
        Route::post('/kidnap', [ScheduleController::class, 'kidnap'])->name('admin.interview.kidnap');
        Route::get('/reschedule', [ScheduleController::class, 'myReschedule'])->name('admin.interview.my-reschedule');
        Route::post('/reschedule', [ScheduleController::class, 'reschedule'])->name('admin.interview.reschedule');
        Route::get('/{schedule_id}', [AnswerController::class, 'getQuestion'])->name('admin.interview.start');
        Route::get('/{schedule_id}/page/{page}', [AnswerController::class, 'getQuestion'])->name('admin.interview.session');
        Route::post('/submit-answer', [AnswerController::class, 'submitAnswer'])->name('admin.interview.submit.answer');
        Route::post('/submit-score', [AnswerController::class, 'submitScore'])->name('admin.interview.submit.score');
        Route::post('/update-answer', [AnswerController::class, 'updateAnswer'])->name('admin.interview.update.answer');
        Route::post('/update-score', [AnswerController::class, 'updateScore'])->name('admin.interview.update.score');
        Route::post('/finish', [AnswerController::class, 'finish'])->name('admin.interview.finish');
    });

    // tolak terima
    Route::prefix('tolak-terima')->group(function () {
        Route::get('/', [ApplicantController::class, 'tolakTerima'])->name('admin.tolak-terima');
        Route::get('/culikAnak', [ApplicantController::class, 'culikAnak'])->name('admin.tolak-terima.culikAnak');
        Route::get('/accepted', [ApplicantController::class, 'getAccepted'])->name('admin.tolak-terima.accepted');
        Route::post('/tolak', [ApplicantController::class, 'tolak'])->name('admin.tolak-terima.tolak');
        Route::post('/terima', [ApplicantController::class, 'terima'])->name('admin.tolak-terima.terima');
        Route::post('/culik', [ApplicantController::class, 'culik'])->name('admin.tolak-terima.culik');
        Route::post('/cancel', [ApplicantController::class, 'cancel'])->name('admin.tolak-terima.cancel');
    });

    Route::prefix('answers')->group(function () {
        Route::get('/{applicant_id}', [AnswerController::class, 'index'])->name('admin.applicant.answer');
    });

    Route::prefix('projects')->controller(ProjectController::class)
        ->group(function () {
            Route::get('{division?}', 'index')->name('admin.project')->middleware('admin.project');
            Route::patch('{division}', 'storeProjectDescription')->name('admin.project.store');
        });

    Route::get('/applicant-cv/{applicant}', [AdminController::class, 'applicantCV'])->name('admin.applicant.cv');

    Route::prefix('setting')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('admin.setting');
        Route::post('/update', [SettingController::class, 'settingUpdate'])->name('admin.setting.update');
    });
});

Route::get('interview-mail', function () {
    $data['applicant'] = Applicant::with(['priorityDivision1', 'priorityDivision2'])->where('email', 'c14230006@john.petra.ac.id')->first()->toArray();
    $data['schedules'] = Schedule::with(['admin', 'date'])->where('applicant_id', $data['applicant']['id'])->get()->toArray();

    return view('mail.interview_schedule', ['data' => $data]);
});
// login
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::get('/processLogin', [AuthController::class, 'login'])->name('processLogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login/{nrp}', [AuthController::class, 'loginPaksa'])->name('loginPaksa');
Route::get('/assets/upload/{path}', [AssetController::class, 'upload'])->where('path', '.*')->name('upload');
Route::get('/coming-soon', function () {
    return view('main.coming-soon');
})->name('applicant.comming.soon');

// Home
Route::get('/', function () {
    return view('main.home');
});
