<?php

namespace App\Http\Controllers;

use Exception;
use ErrorException;
use App\Models\Date;
use App\Models\Admin;
use App\Models\Division;
use App\Models\Schedule;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\UploadedFile;
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

        $applicantData = $this->model->findByNRP($nrp, relations: $this->model->relations());
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
            ['id', 'documents', 'astor']
        );

        $data['title'] = 'Upload Berkas';
        $data['documentTypes'] = self::documentTypes();

        $applicant = Applicant::select('id', 'stage', 'documents')
            ->where('email', $nrp . '@john.petra.ac.id')->first();

        if (!$applicant)
            return 'Silahkan isi form pendaftaran terlebih dahulu di <a href="' . route('applicant.application-form') . '">sini</a>!';

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

        return response()
            ->json(['message' => 'File uploaded successfully!', 'type' => $type])
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
            $data['schedules'] = Schedule::with('date')
                ->where('applicant_id', $applicant->id)
                ->orderBy('type')
                ->get()
                ->toArray();
        } else
            $data['read_only'] = false;

        $data['applicant'] = $applicant->toArray();
        $data['dates'] = Date::select('id', 'date')->where('date', '>', Carbon::now())->get()->toArray();

        // dd($data);

        return view('main.schedule_form', $data);
    }

    public function getTimeSlot(string $date, int $online, string $division)
    {
        $interviewers = Admin::where('division_id', $division)->get();

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

        for ($i = 0; $i < $count; $i++) {
            // get available schedules
            $schedules = Schedule::join('admins', 'schedules.admin_id', '=', 'admins.id')
                ->select('schedules.id', 'schedules.admin_id', 'schedules.date_id', 'schedules.time', 'schedules.online')
                ->where([
                    'admins.division_id' => $validated['division'][$i],
                    'date_id' => $validated['date_id'][$i],
                    'time' => $validated['time'][$i],
                    'status' => 1,
                ])
                ->whereIn('online', $validated['online'][$i] === 1 ? [0, 1] : [0])
                ->get();

            // dd($schedules);

            // favor interviewer that haven't interview anyone
            $admin = Schedule::select('admin_id')
                ->whereIn('admin_id', $schedules->pluck('admin_id'))
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
                    ->whereIn('admin_id', $schedules->pluck('admin_id'))
                    ->where('status', 2)
                    ->groupBy('admin_id')
                    ->orderBy('count', 'asc')
                    ->first();
            }

            // dd($admin);
            $pickedSchedule[] = $schedules->where('admin_id', $admin->admin_id)->first();
        }

        DB::beginTransaction();
        try {
            // update schedule and applicant stage
            $this->updatePartial(['stage' => 3], $applicant->id);

            foreach ($pickedSchedule as $key => $value) {
                // dd($value);
                $type = 0;
                if (!$applicant->priority_division2) $type = 1;
                else if ($isPeran) $type = $key + 1;

                $value->status = 2;
                $value->type = $type;
                $value->online = $validated['online'][$key];
                $value->applicant_id = $applicant->id;
                $value->save();
            }

            $data['applicant'] = $applicant->load(['priorityDivision1', 'priorityDivision2'])->toArray();
            foreach ($pickedSchedule as $s) {
                $data['schedules'][] = $s->load(['admin', 'date'])->toArray();
            }

            $mailer = new MailController();
            $emailed = $mailer->sendInterviewSchedule($data);

            if ($emailed) {
                DB::commit();
                return redirect()->back()->with('success', 'Jadwal interview berhasil dipilih!');
            } else {
                DB::rollback();
                return redirect()->back()->with('error', 'Terjadi kesalahan! Silahkan coba lagi');
            }
        } catch (Exception $e) {
            // dd($e);
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan! Silahkan coba lagi');
        }
    }

    public function downloadCV()
    {
        $nrp = strtolower(session('nrp'));
        $applicant = $this->model->findByNRP($nrp, relations: $this->model->relations());

        if (!$applicant) {
            return 'Pendaftar tidak ditemukan';
        }
        $pdf = $applicant->cv();

        return $pdf->download('CV_' . $nrp . '.pdf');
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

        $filePath = $file->storeAs($path, $storeName);

        return ($filePath) ? $storeName : false;
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
