<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ApplicationRequest;
use App\Models\Applicant;
use App\Models\Division;
use Error;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        $nrp = 'C14210025';
        $res = Http::get('https://john.petra.ac.id/~justin/finger.php?s=' . strtolower($nrp));

        $data['form'] = [];
        try {
            $resJson = $res->json('hasil')[0];
            $data['form']['name'] = $resJson['nama'];
            $data['form']['email'] = strtolower($nrp) . '@john.petra.ac.id';
        } catch (ErrorException $e) {
            Log::warning('NRP {nrp} not found in john API.', ['nrp' => $nrp]);
        }

        $applicantData = Applicant::where('email', strtolower($nrp) . '@john.petra.ac.id')->first();
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

    private static function religions()
    {
        return array_column(Religion::cases(), 'name');
    }

    private static function diets()
    {
        return array_column(Diet::cases(), 'name');
    }   
}

enum Religion {
    case Buddha;
    case Hindu;
    case Islam;
    case Katolik;
    case Konghucu;
    case Kristen;
}

enum Diet {
    case Normal;
    case Vege;
    case Vegan;
}