<?php

namespace App\Http\Controllers;

use App\Events\ApplicantDocumentsUploaded;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\StoreDocumentRequest;
use App\Models\Applicant;
use App\Models\Division;
use Error;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOption\None;

class ApplicantController extends BaseController
{
    private const NRP = 'C14210025';

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

        $nrp = strtolower(self::NRP);
        $res = Http::get('https://john.petra.ac.id/~justin/finger.php?s=' . $nrp);

        $data['form'] = [];
        try {
            $resJson = $res->json('hasil')[0];
            $data['form']['name'] = ucwords($resJson['nama']);
            $data['form']['email'] = $nrp . '@john.petra.ac.id';
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
        $nrp = strtolower(self::NRP);
        $applicant = $this->model->findByEmail(
            $nrp . '@john.petra.ac.id',
            ['id', 'documents', 'astor']
        );

        $data['title'] = 'Upload Berkas';
        $data['documentTypes'] = self::documentTypes($applicant->astor);

        if (!$applicant)
            return 'Silahkan isi form pendaftaran terlebih dahulu di <a href="' . route('applicant.application-form') . '">sini</a>!';

        $data['applicant'] = $applicant->toArray();
        return view('main.documents_form', $data);
    }

    public function storeDocument(StoreDocumentRequest $request, $type)
    {
        $nrp = strtolower(self::NRP);
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
            3,
            self::documentTypes($applicant->astor)
        );

        return response()
            ->json(['message' => 'File uploaded successfully!', 'type' => $type])
            ->setStatusCode(201);
    }

    public function downloadCV()
    {
        $nrp = strtolower(self::NRP);
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
    case Skkk = 'Transkrip SKKK';
    case Schedule = 'Jadwal Kuliah';
    case Frontline_Test = 'Jawaban Tes Calon Frontline';
}
