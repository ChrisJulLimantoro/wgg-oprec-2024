<?php

namespace App\Http\Controllers;

use App\Events\ApplicantDocumentsUploaded;
use ErrorException;
use App\Models\Admin;
use App\Models\Division;
use App\Models\Schedule;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ApplicationRequest;
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
            $data['form']['stage'] = 1;
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

    public function scheduleForm()
    {
        $data['title'] = 'Pilih Jadwal Interview';
        $nrp = strtolower(session('nrp'));

        $applicant = Applicant::where('email', $nrp . '@john.petra.ac.id')->where('stage', '>', 2)->first();

        if (!$applicant)
            return 'Silahkan isi form upload berkas terlebih dahulu di <a href="' . route('applicant.documents-form') . '">sini</a>!';

        $data['applicant'] = $applicant->toArray();

        $interviewers = Admin::whereIn('division_id', [$applicant->priority_division1, $applicant->priority_division1])->get();

        $schedules = Schedule::with(['date', 'admin'])
            ->whereIn('admin_id', $interviewers->pluck('id'))
            ->get()
            ->toArray();

        foreach ($schedules as $s) {
            $data['schedules'][] = [
                'id' => $s['id'],
                'date' => $s['date']['date'],
                'time' => $s['time'],
                'admin' => $s['admin']['name'],
                'admin_id' => $s['admin']['id'],
                'date_ud' => $s['date']['id'],
            ];
        }

        $dates = array_column($data['schedules'], 'date');
        $time = array_column($data['schedules'], 'time');

        array_multisort($dates, SORT_ASC, $time, SORT_ASC, $data['schedules']);

        dd($data['schedules']);
        return view('main.schedule_form', $data);
    }

    public function pickSchedule(Request $request)
    {
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
