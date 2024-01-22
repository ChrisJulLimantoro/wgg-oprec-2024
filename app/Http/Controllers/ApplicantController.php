<?php

namespace App\Http\Controllers;

use Exception;
use ErrorException;
use App\Models\Date;
use App\Models\Admin;
use App\Models\Major;
use App\Mail\adminMail;
use App\Models\Faculty;
use App\Models\Setting;
use App\Models\Division;
use App\Models\Schedule;
use App\Jobs\SendMailJob;
use App\Models\Applicant;
use App\Mail\scheduleMail;
use App\Mail\rescheduleMail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\MailController;
use App\Http\Requests\ApplicationRequest;
use App\Events\ApplicantDocumentsUploaded;
use App\Http\Requests\PickScheduleRequest;
use App\Http\Requests\StoreDocumentRequest;

class ApplicantController extends BaseController
{
    public function __construct(Applicant $model)
    {
        parent::__construct($model);
    }

    public function applicationForm()
    {
        $data['title'] = 'Form Pendaftaran';
        $data['religions'] = self::religions();
        $data['diets'] = self::diets();

        $divisions = Division::all(['id', 'name'])->toArray();
        $excludedDivisions = ['Badan Pengurus Harian', 'Opening', 'Closing'];
        $data['divisions'] = array_filter($divisions, function ($division) use ($excludedDivisions) {
            return !in_array($division['name'], $excludedDivisions);
        });

        $nrp = strtolower(session('nrp'));
        $res = Http::get('http://john.petra.ac.id/~justin/finger.php?s=' . $nrp);

        $data['form'] = [];
        try {
            $resJson = $res->json('hasil')[0];
            $data['form']['name'] = ucwords(strtolower($resJson['nama']));
            $data['form']['email'] = $nrp . '@john.petra.ac.id';
            $data['form']['stage'] = 0;
        } catch (ErrorException $e) {
            Log::warning('NRP {nrp} not found in john API.', ['nrp' => $nrp]);
        }

        $classOf = (int) substr($nrp, 3, 2);
        $facultyCode = strtoupper(substr($nrp, 0, 1));
        $majorCode = substr($nrp, 2, 1);
        $facultiesId = $classOf < 23
            ? Faculty::select('id')->where('code', $facultyCode)
            : Faculty::select('id')->whereNotNull('english_name')->where('code', $facultyCode);
        $data['majors'] = Major::select('id', 'name')
            ->whereIn('faculty_id', $facultiesId)
            ->where('code', $majorCode)
            ->get();

        $applicantData = $this->model->findByNRP($nrp);
        if ($applicantData) {
            $data['form'] = $applicantData->toArray();
        }

        return view('main.application_form', $data);
    }

    public function storeApplication(ApplicationRequest $request)
    {
        $this->store($request);

        return redirect()->back()
            ->with('success', 'Pendaftaran berhasil!');
    }

    public function updateApplication(ApplicationRequest $request, $id)
    {
        $this->updatePartial($request->validated(), $id);

        return redirect()->back()
            ->with('success', 'Biodata berhasil diubah!');
    }

    public function documentsForm()
    {
        $nrp = strtolower(session('nrp'));
        $applicant = $this->model->findByEmail(
            $nrp . '@john.petra.ac.id',
            ['id', 'documents', 'astor', 'stage']
        );

        if (!$applicant)
            return 'Silahkan isi form pendaftaran terlebih dahulu di <a href="' . route('applicant.application-form') . '">sini</a>!';

        $data['title'] = 'Upload Berkas';
        $data['documentTypes'] = self::documentTypes($applicant->astor);


        $data['applicant'] = $applicant->toArray();
        return view('main.documents_form', $data);
    }

    public function storeDocument(StoreDocumentRequest $request, $type)
    {
        $nrp = strtolower(session('nrp'));
        $applicant = $this->model->findByNRP($nrp);
        $storeName = self::saveFile($request->file($type), $applicant, $type);

        if (!$storeName) {
            return response()
                ->json(['message' => 'Failed to upload file. Please try again!'])
                ->setStatusCode(500);
        }

        $applicant->addDocument($type, $storeName);
        ApplicantDocumentsUploaded::dispatch(
            $applicant,
            2,
            self::documentTypes($applicant->astor)
        );

        $applicant->refresh();

        return response()
            ->json([
                'message' => 'File uploaded successfully!',
                'type' => $type,
                'stageCompleted' => $applicant->stage > 1
            ])
            ->setStatusCode(201);
    }

    public function cekPeran(string $email): bool
    {
        $applicant = Applicant::where('email', $email)->first();
        $peran = Division::where('name', 'Peran')->first();

        if ($applicant->priority_division1 === $peran->id || $applicant->priority_division2 === $peran->id)
            return true;
        else
            return false;
    }

    public function scheduleForm()
    {
        $data['title'] = 'Pilih Jadwal Interview';

        $applicant = Applicant::with(['priorityDivision1', 'priorityDivision2'])
            ->where('email', session('email'))
            ->where('stage', '>=', 2)
            ->first();

        if (!$applicant)
            return 'Silahkan isi form upload berkas terlebih dahulu di <a href="' . route('applicant.documents-form') . '">sini</a>!';

        if ($applicant->astor) return;

        if ($this->cekPeran($applicant->email) && $applicant->priority_division2 != null)
            $data['double_interview'] = true;
        else
            $data['double_interview'] = false;

        if ($applicant->stage >= 3) {
            $data['read_only'] = true;
            $data['schedules'] = Schedule::with('date')->with('admin')
                ->where('applicant_id', $applicant->id)
                ->orderBy('type')
                ->get()
                ->toArray();

            //reschedule
            $reschedule = [];

            foreach ($data['schedules'] as $i => $schedule) {
                $reschedule[$i] = $this->canReschedule($schedule['date']['date'], $schedule['time']);
            }

            // dd($reschedule);

            $data['reschedule'] = $reschedule;
        } else
            $data['read_only'] = false;

        $data['applicant'] = $applicant->toArray();

        // dd(Carbon::now()->addDays(1)->format('Y-m-d'));
        $data['dates'] = Date::select('id', 'date')->where('date', '>', Carbon::now())->get()->toArray();

        // dd($data);

        return view('main.schedule_form', $data);
    }

    public function getTimeSlot(Request $request)
    {
        $date = $request->date;
        $online = intval($request->online);
        $division = $request->division;
        $isBphEnabled = Setting::where('key', 'BPH')->first()->value == 1;

        if ($isBphEnabled) $bph = Division::where('name', 'Badan Pengurus Harian')->first();

        $interviewers = Admin::whereIn('division_id', $isBphEnabled ? [$division, $bph->id] : [$division])->get();

        $schedules = Schedule::select('time')
            ->where([
                'date_id' => $date,
                'status' => 1,
            ])
            ->whereIn('online', $online === 1 ? [0, 1] : [0])
            ->whereIn('admin_id', $interviewers->pluck('id'))
            ->groupBy('time')
            ->orderBy('time', 'asc')
            ->pluck('time');

        return response()->json(['success' => true, 'data' => $schedules]);
    }

    public function pickSchedule(PickScheduleRequest $request)
    {
        $validated = $request->validated();
        $isPeran = $this->cekPeran(session('email'));
        $applicant = Applicant::where('email', session('email'))->first();

        if ($isPeran && $applicant->priority_division2 != null) {
            // check if both date and time are the same for double interview
            if ($validated['date_id'][0] === $validated['date_id'][1] && $validated['time'][0] === $validated['time'][1]) {
                return redirect()->back()->with('error', 'Jadwal interview tidak boleh sama!');
            }
        } else {
            $schedule = Schedule::where('applicant_id', $applicant->id)->first();

            if ($schedule) {
                return redirect()->back()->with('error', 'Anda sudah memilih jadwal interview!');
            }
        }

        $pickedSchedule = [];
        $count = $isPeran && $applicant->priority_division2 != null ? 2 : 1;
        $onsiteOnly = ['Creative', 'Regulasi'];

        for ($i = 0; $i < $count; $i++) {
            // check whether the selected division allow online interview
            $division = Division::where('id', $validated['division'][$i])->first();
            if ($validated['online'][$i] == 1 && in_array($division->name, $onsiteOnly)) {
                return redirect()->back()->with('error', 'Divisi ' . $division->name . ' hanya menerima interview onsite!');
            }

            // get available schedules
            $schedules = Schedule::join('admins', 'schedules.admin_id', '=', 'admins.id')
                ->select('schedules.id', 'schedules.admin_id', 'schedules.date_id', 'schedules.time', 'schedules.online')
                ->where([
                    'admins.division_id' => $validated['division'][$i],
                    'date_id' => $validated['date_id'][$i],
                    'time' => $validated['time'][$i],
                    'status' => 1,
                ])
                ->whereIn('online', $validated['online'][$i] == 1 ? [0, 1] : [0])
                ->get();

            // dd($schedules);

            // choose interviewer from selected division
            $admin = $this->chooseInterviewer($schedules->pluck('admin_id'));
            // dd($admin);

            // if still there's none, pick interviewer from bph division
            if (!$admin && ($division->name == 'Peran' || Setting::where('key', 'BPH')->first()->value == 1)) {
                $bph = Division::where('name', 'Badan Pengurus Harian')->first();

                $peranExcluded = [
                    'f11210017@john.petra.ac.id',
                ];

                $schedules = Schedule::join('admins', 'schedules.admin_id', '=', 'admins.id')
                    ->select('schedules.id', 'schedules.admin_id', 'schedules.date_id', 'schedules.time', 'schedules.online')
                    ->where([
                        'admins.division_id' => $bph->id,
                        'date_id' => $validated['date_id'][$i],
                        'time' => $validated['time'][$i],
                        'status' => 1,
                    ])
                    ->whereNotIn('email', $division->name == 'Peran' ? [$peranExcluded] : [])
                    ->whereIn('online', $validated['online'][$i] == 1 ? [0, 1] : [0])
                    ->get();
                
                $admin = $this->chooseInterviewer($schedules->pluck('admin_id'));
            }
            
            // dd($admin);
            $pickedSchedule[] = $schedules->where('admin_id', $admin->admin_id)->first();
        }

        DB::beginTransaction();
        try {
            // update schedule and applicant stage
            $this->updatePartial(['stage' => 3], $applicant->id);

            foreach ($pickedSchedule as $key => $value) {
                $schedule = Schedule::where('id', $value->id)->lockForUpdate()->first();

                $type = 0;
                if (!$applicant->priority_division2) $type = 1;
                if ($isPeran) $type = $key + 1;

                $schedule->status = 2;
                $schedule->type = $type;
                $schedule->online = $validated['online'][$key];
                $schedule->applicant_id = $applicant->id;
                $schedule->save();

                $data['schedules'][] = $schedule->load(['admin', 'date']);
            }

            $data['applicant'] = $applicant->load(['priorityDivision1', 'priorityDivision2']);

            $emailSettings = Setting::where('key', 'Email')->first();

            // dd($emailSettings);

            if ($emailSettings->value == 1) {
                $userMailer = new MailController(new scheduleMail($data));
                // $userMailer->sendMail($data);
                dispatch(new SendMailJob($userMailer, $data));

                foreach ($data['schedules'] as $s) {
                    $adminMailer = new MailController(new adminMail([
                        'schedules' => $s,
                        'applicant' => $data['applicant']
                    ]));
                    // $adminMailer->sendMail($data);
                    dispatch(new SendMailJob($adminMailer, $data));
                }

                DB::commit();
                return redirect()->back()->with('success', 'Jadwal interview berhasil dipilih!');
            }

            DB::commit();
            return redirect()->back()->with('success', 'Jadwal interview berhasil dipilih!');
        } catch (Exception $e) {
            // dd($e);
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan! Silahkan coba lagi');
        }
    }

    public function chooseInterviewer(Collection $admin_id)
    {
        // favor interviewer that haven't interview anyone
        $admin = Schedule::select('admin_id')
            ->whereIn('admin_id', $admin_id)
            ->whereNotExists(function ($query) {
                $query->select("*")
                    ->from('schedules as s')
                    ->whereColumn('s.admin_id', 'schedules.admin_id')
                    ->where('s.status', 2);
            })
            ->groupBy('admin_id')
            ->first();

        // if there's none, pick interviewer with least interviewees
        if (!$admin) {
            $admin = Schedule::select('admin_id', DB::raw("COUNT(*) as count"))
                ->whereIn('admin_id', $admin_id)
                ->where('status', 2)
                ->groupBy('admin_id')
                ->orderBy('count', 'asc')
                ->first();
        }

        return $admin;
    }

    public function reschedule(Request $request)
    {
        $schedule_id = $request->schedule_id;
        $email = session('email');

        $applicant = $this->model->findByEmail($email);
        $schedule = $applicant->schedules()->where('id', $schedule_id);

        if ($schedule) {
            $schedule = $schedule->with('date')->first();
            $reschedule_status = $applicant->reschedule;

            //check current time
            if (!$this->canReschedule($schedule->date->date, $schedule->time)) {
                return redirect()->back()->with('error', 'Tidak dapat mengganti jadwal karena telah melebihi batas waktu');
            }

            $index = $schedule->type == 2 ? 1 : 0; //index for reschedule status to update

            //check already request reschedule
            if ($reschedule_status[$index] > 0) {
                return redirect()->back()->with('success_confirm', 'Pengajuan ganti jadwal sudah diajukan. Silahkan menghubungi contact person untuk menentukan jadwal terbaru.');
            }

            //update reschadule status
            $applicant->reschedule = $index == 0 ? "1" . $reschedule_status[1] : $reschedule_status[0] . "1";
            $applicant->save();

            $data['applicant'] = $applicant->load(['priorityDivision1', 'priorityDivision2']);
            $data['schedules'] = $schedule->load(['admin', 'date']);

            $emailSettings = Setting::where('key', 'Email')->first();

            if ($emailSettings->value == 1) {
                $rescheduleMailer = new MailController(new rescheduleMail($data));
                dispatch(new SendMailJob($rescheduleMailer, $data));
            }

            return redirect()->back()->with('success_confirm', 'Pengajuan ganti jadwal sudah diajukan. Silahkan menghubungi contact person untuk menentukan jadwal terbaru.');
        }

        return redirect()->back()->with('error', 'Terjadi kesalahan! Silahkan coba lagi');
    }

    public function canReschedule($date, $time)
    {
        date_default_timezone_set('Asia/Jakarta');

        //max date to reschedule
        $tolerate = "-1 day +20 hours";                     //1 day before schedule and close at 20:00
        // $tolerate = "-1 day +" . $time ." hours";       //exactly 24 hours before schedule

        $current_date = date('Y-m-d H:i:s');
        $max_date = date("Y-m-d H:i:s", strtotime($tolerate, strtotime($date)));

        return $current_date < $max_date;
    }

    public function previewCV()
    {
        $nrp = strtolower(session('nrp'));
        $applicant = $this->model->findByNRP($nrp, relations: $this->model->relations());

        if (!$applicant) {
            return 'Pendaftar tidak ditemukan';
        }
        if ($applicant->stage < 2) {
            return 'Pastikan anda sudah mengisi form pendaftaran dan upload berkas terlebih dahulu';
        }
        $pdf = $applicant->cv();

        return $pdf->stream('CV_' . $nrp . '.pdf');
    }


    private static function religions()
    {
        return array_column(Religion::cases(), 'name');
    }

    private static function diets()
    {
        return array_column(Diet::cases(), 'name');
    }

    public static function documentTypes($isAstor = true)
    {
        $allDocuments = array_column(DocumentType::cases(), 'value', 'name');

        if ($isAstor) {
            return $allDocuments;
        }

        return array_filter($allDocuments, function ($v, $k) {
            return $k !== DocumentType::Frontline_Test->name;
        }, ARRAY_FILTER_USE_BOTH);
    }

    private static function saveFile(UploadedFile $file, Applicant $applicant, $type)
    {
        $type = strtolower($type);
        $nrp = $applicant->getNRP();
        $timestamp = time();

        $path = 'public/uploads/' . $type;
        $storeName = sprintf('%s_%s_%d.%s', $nrp, $type, $timestamp, $file->extension());

        $filePath = $file->storePubliclyAs($path, $storeName);

        return ($filePath) ? $storeName : false;
    }

    // tolak-terima
    public function tolakTerima()
    {
        $data['title'] = 'Tolak Terima';
        $schedule = Schedule::with(['applicant', 'applicant.priorityDivision1', 'applicant.priorityDivision2', 'applicant.divisionAccepted'])
            ->where('status', 2)
            ->whereHas('applicant', function ($query) {
                $query->where('stage', '>', 3);
            })
            ->get();
        $data['applicant'] = [];
        $i = 0;
        foreach ($schedule as $b) {
            $a = $b->applicant;
            if ($a->priorityDivision1->id != session('division_id') && $a->priorityDivision2->id != session('division_id') && session('role') != "bph") {
                continue;
            }
            $temp = [];
            $temp['no'] = $i + 1;
            $temp['id'] = $a->id;
            $temp['nrp'] = $a->getNRP();
            $temp['name'] = $a->name;
            $temp['prioritas1'] = $a->priorityDivision1->name;
            $temp['prioritas1_id'] = $a->priorityDivision1->id;
            $temp['prioritas2'] = $a->priorityDivision2->name;
            $temp['prioritas2_id'] = $a->priorityDivision2->id;
            $temp['divisi'] = $a->divisionAccepted;
            $temp['email'] = $a->email;
            $temp['gender'] = $a->gender == 0 ? 'Laki-laki' : 'Perempuan';
            $temp['religion'] = $a->religion;
            $temp['birth_place'] = $a->birthplace;
            $temp['birth_date'] = $a->birthdate;
            $temp['province'] = $a->province;
            $temp['city'] = $a->city;
            $temp['address'] = $a->address;
            $temp['postal_code'] = $a->postal_code;
            $temp['phone'] = $a->phone;
            $temp['line'] = $a->line;
            $temp['instagram'] = $a->instagram;
            $temp['tiktok'] = $a->tiktok;
            $temp['gpa'] = $a->gpa;
            $temp['motivation'] = $a->motivation;
            $temp['commitment'] = $a->commitment;
            $temp['strength'] = $a->strength;
            $temp['weakness'] = $a->weakness;
            $temp['experience'] = $a->experience;
            $temp['diet'] = $a->diet;
            $temp['allergy'] = $a->allergy;

            // button action atau acceptance status logic
            $temp['action1'] =  "
                <button
                type='button'
                class='btn-terima block mb-2 rounded bg-success px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#14a44d] transition duration-150 ease-in-out hover:bg-success-600 hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:bg-success-600 focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:outline-none focus:ring-0 active:bg-success-700 active:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(20,164,77,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)]'
                data-te-index='$i' data-te-priority='1' 
                >
                Terima Pilihan1
                </button>
                
                <button
                type='button'
                class='btn-tolak block rounded bg-danger px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#dc4c64] transition duration-150 ease-in-out hover:bg-danger-600 hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:bg-danger-600 focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:outline-none focus:ring-0 active:bg-danger-700 active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(220,76,100,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)]'
                data-te-index='$i'data-te-priority='1' 
                >
                Tolak Pilihan1
                </button>
                ";

            $temp['action2'] =  "
                <button
                type='button'
                class='btn-terima block mb-2 rounded bg-success px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#14a44d] transition duration-150 ease-in-out hover:bg-success-600 hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:bg-success-600 focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:outline-none focus:ring-0 active:bg-success-700 active:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(20,164,77,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)]'
                data-te-index='$i' data-te-priority='2'  
                >
                Terima Pilihan2
                </button>
                
                <button
                type='button'
                class='btn-tolak block rounded bg-danger px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#dc4c64] transition duration-150 ease-in-out hover:bg-danger-600 hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:bg-danger-600 focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:outline-none focus:ring-0 active:bg-danger-700 active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(220,76,100,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)]'
                data-te-index='$i' data-te-priority='2'
                >
                Tolak Pilihan2
                </button>
                ";
            if ($a->acceptance_stage == 2) {
                // diterima prioritas1
                $temp['action1'] = "<div class='text-center w-full '> 
                    <i class='fa-regular fa-circle-check fa-lg' style='color: #16a34a;'></i>        
                </div>
                <h1 class='text-green-600 font-bold text-center'>Accepted</h1>
                
                <button
                type='button' class='btn-cancel mx-auto block rounded bg-danger px-2 pb-2 pt-2.5 text-[0.5rem] font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#dc4c64] transition duration-150 ease-in-out hover:bg-danger-600 hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:bg-danger-600 focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:outline-none focus:ring-0 active:bg-danger-700 active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(220,76,100,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)]'
                data-te-index='$i' data-te-priority='1'>cancel</button>";
            } else if ($a->acceptance_stage == 3) {
                // ditolak prioritas1
                $temp['action1'] = "<div class='text-center w-full '> 
                <i class=' fa-sharp fa-regular fa-circle-xmark fa-lg' style='color: #dc2626;'></i>
                </div>
                <h1 class='text-red-600 font-bold text-center'>Tertolak</h1>
                
                <button
                type='button' class='btn-cancel mx-auto block rounded bg-danger px-2 pb-2 pt-2.5 text-[0.5rem] font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#dc4c64] transition duration-150 ease-in-out hover:bg-danger-600 hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:bg-danger-600 focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:outline-none focus:ring-0 active:bg-danger-700 active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(220,76,100,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)]'
                data-te-index='$i' data-te-priority='1'>cancel</button>";
            } else if ($a->acceptance_stage == 4) {
                // diterima prioritas 2
                $temp['action1'] = "<div class='text-center w-full '> 
                <i class=' fa-sharp fa-regular fa-circle-xmark fa-lg' style='color: #dc2626;'></i>
                </div>
                <h1 class='text-red-600 font-bold text-center'>Tertolak</h1>
                <button
                type='button' class='btn-cancel mx-auto block rounded bg-danger px-2 pb-2 pt-2.5 text-[0.5rem] font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#dc4c64] transition duration-150 ease-in-out hover:bg-danger-600 hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:bg-danger-600 focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:outline-none focus:ring-0 active:bg-danger-700 active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(220,76,100,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)]'
                data-te-index='$i' data-te-priority='1'>cancel</button>";

                $temp['action2'] = "<div class='text-center w-full '> 
                <i class='fa-regular fa-circle-check fa-lg' style='color: #16a34a;'></i>        
            </div>
            <h1 class='text-green-600 font-bold text-center'>Accepted</h1>
            
            <button
                type='button' class='btn-cancel mx-auto block rounded bg-danger px-2 pb-2 pt-2.5 text-[0.5rem] font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#dc4c64] transition duration-150 ease-in-out hover:bg-danger-600 hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:bg-danger-600 focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:outline-none focus:ring-0 active:bg-danger-700 active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(220,76,100,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)]'
                data-te-index='$i' data-te-priority='2'>cancel</button>";
            } else if ($a->acceptance_stage == 5) {
                // ditolak prioritas 2
                $temp['action1'] = "<div class='text-center w-full '> 
                <i class=' fa-sharp fa-regular fa-circle-xmark fa-lg' style='color: #dc2626;'></i>
                </div>
                <h1 class='text-red-600 font-bold text-center'>Tertolak</h1>
                <button
                type='button' class='btn-cancel mx-auto block rounded bg-danger px-2 pb-2 pt-2.5 text-[0.5rem] font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#dc4c64] transition duration-150 ease-in-out hover:bg-danger-600 hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:bg-danger-600 focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:outline-none focus:ring-0 active:bg-danger-700 active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(220,76,100,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)]'
                data-te-index='$i' data-te-priority='1'>cancel</button>";

                $temp['action2'] = "<div class='text-center w-full '> 
                <i class=' fa-sharp fa-regular fa-circle-xmark fa-lg' style='color: #dc2626;'></i>
                </div>
                <h1 class='text-red-600 font-bold text-center'>Tertolak</h1>
               
                <button
                type='button' class='btn-cancel mx-auto block rounded bg-danger px-2 pb-2 pt-2.5 text-[0.5rem] font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#dc4c64] transition duration-150 ease-in-out hover:bg-danger-600 hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:bg-danger-600 focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:outline-none focus:ring-0 active:bg-danger-700 active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(220,76,100,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)]'
                data-te-index='$i' data-te-priority='2'>cancel</button>";
            } else if ($a->acceptance_stage == 6) {
                // terculik
                $name = $a->divisionAccepted->slug;
                $temp['action1'] = "<div class='text-center w-full '> 
                <i class='fa-solid fa-circle-info fa-lg' style='color: #fb923c;'></i>   
                </div>
                <h1 class='text-orange-500 font-bold text-center'>Terculik $name </h1>";

                $temp['action2'] = $temp['action1'];
            }
            $data['applicant'][] = $temp;
            $i++;
        }
        $data['applicant'] = json_encode($data['applicant']);

        // dd($data['applicant']);

        return view('admin.tolak_terima.tolakTerima', $data);
    }

    public function culikAnak()
    {
        $data['title'] = 'Tolak Terima';
        $schedule = Schedule::with(['applicant', 'applicant.priorityDivision1', 'applicant.priorityDivision2', 'applicant.divisionAccepted'])
            ->where('status', 2)
            ->whereHas('applicant', function ($query) {
                $query->where('stage', '>', 3)
                    ->where('acceptance_stage', '>=', 5);
            })
            ->get();

        $data['applicant'] = [];
        $i = 0;
        foreach ($schedule as $b) {
            $a = $b->applicant;
            $temp = [];
            $temp['no'] = $i + 1;
            $temp['id'] = $a->id;
            $temp['nrp'] = $a->getNRP();
            $temp['name'] = $a->name;
            $temp['prioritas1'] = $a->priorityDivision1->name;
            $temp['prioritas1_id'] = $a->priorityDivision1->id;
            $temp['prioritas2'] = $a->priorityDivision2->name;
            $temp['prioritas2_id'] = $a->priorityDivision2->id;
            $temp['divisi'] = $a->divisionAccepted;
            $temp['email'] = $a->email;
            $temp['gender'] = $a->gender == 0 ? 'Laki-laki' : 'Perempuan';
            $temp['religion'] = $a->religion;
            $temp['birth_place'] = $a->birthplace;
            $temp['birth_date'] = $a->birthdate;
            $temp['province'] = $a->province;
            $temp['city'] = $a->city;
            $temp['address'] = $a->address;
            $temp['postal_code'] = $a->postal_code;
            $temp['phone'] = $a->phone;
            $temp['line'] = $a->line;
            $temp['instagram'] = $a->instagram;
            $temp['tiktok'] = $a->tiktok;
            $temp['gpa'] = $a->gpa;
            $temp['motivation'] = $a->motivation;
            $temp['commitment'] = $a->commitment;
            $temp['strength'] = $a->strength;
            $temp['weakness'] = $a->weakness;
            $temp['experience'] = $a->experience;
            $temp['diet'] = $a->diet;
            $temp['allergy'] = $a->allergy;

            if ($a->acceptance_stage == 6 && $a->division_accepted == session('division_id')) {
                $temp['action'] = "<button
                type='button' class='btn-cancel block rounded bg-danger px-4 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#dc4c64] transition duration-150 ease-in-out hover:bg-danger-600 hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:bg-danger-600 focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:outline-none focus:ring-0 active:bg-danger-700 active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(220,76,100,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)]'
                data-te-index='$i' data-te-priority='3'>cancel</button>";
            } else if ($a->acceptance_stage == 6) {
                $name = $a->divisionAccepted->slug;
                $temp['action'] = "<div class='text-center w-full '> 
                <i class='fa-solid fa-circle-info fa-lg' style='color: #fb923c;'></i>   
                </div>
                <h1 class='text-orange-500 font-bold text-center'>Terculik $name </h1>";
            } else {
                $temp['action'] = "<button
                type='button' class='btn-culik block mb-2 rounded bg-success px-4 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#14a44d] transition duration-150 ease-in-out hover:bg-success-600 hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:bg-success-600 focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:outline-none focus:ring-0 active:bg-success-700 active:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(20,164,77,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)]'
                data-te-index='$i'>Culik Anak 
                </button>";
            }
            $data['applicant'][] = $temp;
            $i++;
        }
        $data['applicant'] = json_encode($data['applicant']);

        return view('admin.tolak_terima.culikAnak', $data);
    }

    public function terima(Request $request)
    {
        $data = $request->only(['id', 'priority']);
        $applicant = $this->getById($data['id']);
        $admin_division = Division::where('id', session('division_id'))->first();

        // check acceptance stage
        if ($data['priority'] == 1) {
            // check apakah punya kuasa
            if ($admin_division->id != $applicant->priorityDivision1->id && $admin_division->slug != "bph") {
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki kuasa untuk menerima pilihan 1']);
            }

            // terima prioritas 1
            if ($applicant->acceptance_stage == 1) {
                $this->updatePartial(['acceptance_stage' => 2, 'division_accepted' => $applicant->priorityDivision1->id], $data['id']);
                return response()->json(['success' => true, 'message' => 'Berhasil menerima anak di pilihan 1']);
            }
        }

        if ($data['priority'] == 2) {
            // check apakah punya kuasa
            if ($admin_division->id != $applicant->priorityDivision2->id && $admin_division->slug != "bph") {
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki kuasa untuk menerima pilihan 2']);
            }

            if ($applicant->acceptance_stage == 3) {
                $this->updatePartial(['acceptance_stage' => 4, 'division_accepted' => $applicant->priorityDivision2->id], $data['id']);
                return response()->json(['success' => true, 'message' => 'Berhasil menerima anak di pilihan 2']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Gagal menerima anak']);
    }

    public function tolak(Request $request)
    {
        $data = $request->only(['id', 'priority']);
        $applicant = $this->getById($data['id']);
        $admin_division = Division::where('id', session('division_id'))->first();
        // check acceptance stage
        if ($data['priority'] == 1) {
            // check apakah punya kuasa
            if ($admin_division->id != $applicant->priorityDivision1->id && $admin_division->slug != "bph") {
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki kuasa untuk menolak pilihan 1']);
            }

            // terima prioritas 1
            if ($applicant->acceptance_stage == 1) {
                $this->updatePartial(['acceptance_stage' => 3], $data['id']);
                return response()->json(['success' => true, 'message' => 'Berhasil menolak anak di pilihan 1']);
            }
        }

        if ($data['priority'] == 2) {
            // check apakah punya kuasa
            if ($admin_division->id != $applicant->priorityDivision2->id && $admin_division->slug != "bph") {
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki kuasa untuk menolak pilihan 2']);
            }

            if ($applicant->acceptance_stage == 3) {
                $this->updatePartial(['acceptance_stage' => 5], $data['id']);
                return response()->json(['success' => true, 'message' => 'Berhasil menolak anak di pilihan 2']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Gagal menolak anak']);
    }

    public function culik(Request $request)
    {
        // dia di stage 5 dan yang accept bukan bph
        $data = $request->only(['id']);
        $applicant = $this->getById($data['id']);
        if (session('role') == "bph") {
            return response()->json(['success' => false, 'message' => 'BPH tidak bisa culik anak']);
        }

        if ($applicant->acceptance_stage == 5) {
            // lakukan culik
            $role = session('role');
            $this->updatePartial(['acceptance_stage' => 6, 'division_accepted' => session('division_id')], $data['id']);
            return response()->json(['success' => true, 'message' => "Berhasil menculik ke $role"]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal menculik anak']);
    }
    public function cancel(Request $request)
    {
        $data = $request->only(['id', 'priority']);
        $applicant = $this->getById($data['id']);
        $admin_division = Division::where('id', session('division_id'))->first();

        // check stage priority
        if ($data['priority'] == 1) {
            // check apakah punya kuasa
            if ($admin_division->id != $applicant->priorityDivision1->id && $admin_division->slug != "bph") {
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki kuasa untuk cancel pilihan 1']);
            }

            // cancel prioritas 1
            if ($applicant->acceptance_stage <= 3 && $applicant->acceptance_stage >= 2) {
                $this->updatePartial(['acceptance_stage' => 1, 'division_accepted' => null], $data['id']);
                return response()->json(['success' => true, 'message' => 'Berhasil cancel anak di pilihan 1']);
            }
        } else if ($data['priority'] == 2) {
            // check apakah punya kuasa
            if ($admin_division->id != $applicant->priorityDivision2->id && $admin_division->slug != "bph") {
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki kuasa untuk cancel pilihan 2']);
            }

            // cancel prioritas 2
            if ($applicant->acceptance_stage <= 5 && $applicant->acceptance_stage >= 4) {
                $this->updatePartial(['acceptance_stage' => 3, 'division_accepted' => null], $data['id']);
                return response()->json(['success' => true, 'message' => 'Berhasil cancel anak di pilihan 2']);
            }
        }

        //untuk culik
        else if ($data['priority'] == 3) {
            // check apakah punya kuasa
            if ($admin_division->id != $applicant->division_accepted && $admin_division->slug != "bph") {
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki kuasa untuk cancel anak']);
            }

            // cancel culik
            if ($applicant->acceptance_stage == 6) {
                $this->updatePartial(['acceptance_stage' => 5, 'division_accepted' => null], $data['id']);
                return response()->json(['success' => true, 'message' => 'Berhasil cancel anak']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Gagal cancel anak, Tidak di stage yang tepat']);
    }

    public function getAccepted()
    {
        $accepted = Applicant::with(['divisionAccepted', 'major'])->where('division_accepted', '!=', null)->get()->toArray();
        $data['title'] = 'Accepted';
        $temp = [
            'it' => [],
            'sekret' => [],
            'peran' => [],
            'acara' => [],
            'creative' => [],
            'perkap' => [],
            'regul' => [],
            'konsum' => [],
            'kesehatan' => [],
        ];
        foreach ($accepted as $a) {
            $temp[$a['division_accepted']['slug']][] = [
                'nrp' => substr($a['email'], 0, 9),
                'name' => $a['name'],
                'address' => $a['address'],
                'type' => $a['acceptance_stage'],
                'stage' => $a['stage'],
                'gpa' => $a['gpa'],
                'major' => $a['major']['english_name'],
                'link' => route('admin.applicant.cv', $a['id']),
            ];
        }
        $data['accepted'] = json_encode($temp);
        return view('admin.tolak_terima.accepted', $data);
    }
}

enum Religion
{
    case Buddha;
    case Hindu;
    case Islam;
    case Katolik;
    case Konghucu;
    case Kristen;
}

enum Diet
{
    case Normal;
    case Vege;
    case Vegan;
}

enum DocumentType: String
{
    case Photo = 'Foto Diri 3x4';
    case Ktm = 'KTM / Profile Petra Mobile';
    case Grades = 'Transkrip Nilai';
    case Skkk = 'Transkrip SKKK Petra Mobile';
    case Schedule = 'Jadwal Kuliah';
    case Frontline_Test = 'Jawaban Tes Calon Frontline';
}
