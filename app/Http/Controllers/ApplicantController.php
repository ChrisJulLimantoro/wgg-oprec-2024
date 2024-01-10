<?php

namespace App\Http\Controllers;

use App\Events\ApplicantDocumentsUploaded;
use Error;
use ErrorException;
use PhpOption\None;
use App\Models\Admin;
use App\Models\Division;
use App\Models\Schedule;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\StoreDocumentRequest;

class ApplicantController extends BaseController
{
    private const NRP = 'C14210017';

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
        $nrp = strtolower(self::NRP);
        $applicant = $this->model->findByEmail(
            $nrp . '@john.petra.ac.id',
            ['id', 'documents', 'astor']
        );

        $data['title'] = 'Upload Berkas';
        $data['documentTypes'] = self::documentTypes();
        $nrp = strtolower(self::NRP);

        $applicant = Applicant::select('id', 'stage', 'documents')
            ->where('email', $nrp . '@john.petra.ac.id')->first();

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

    public function scheduleForm() {
        $data['title'] = 'Pilih Jadwal Interview';
        $nrp = strtolower(self::NRP);

        $applicant = Applicant::where('email', $nrp . '@john.petra.ac.id')->where('stage', '>', 2)->first();

        if (!$applicant)
            return 'Silahkan isi form upload berkas terlebih dahulu di <a href="' . route('applicant.documents-form') . '">sini</a>!';

        $data['applicant'] = $applicant->toArray();

        $interviewers = Admin::whereIn('division_id', [$applicant->priority_division1, $applicant->priority_division1])->get();

        $schedules = Schedule::with(['date', 'admin'])
            ->whereIn('admin_id', $interviewers->pluck('id'))   
            ->get()
            ->toArray();

        foreach($schedules as $s) {
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

    public function pickSchedule(Request $request) {

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

    // tolak-terima
    public function tolakTerima(){
        $data['title'] = 'Tolak Terima';
        // ambil dari schedule dan phase anak yang sudah selesai interview 
        $applicant =  $this->model->with(['schedule','schedule.admin','schedule.date', 'priorityDivision1','priorityDivision2','divisionAccepted'])
        ->where('stage','>',3)
        ->whereHas('schedule',function ($query)  
        {
            $query->where('status',2);
        })
        ->get();
        
        // $test2 = Applicant::with(['schedule','schedule.admin','prioritydivision1','prioritydivision2'])->get();
        // dd($test2[0]->schedule->date->date);
        // dd($test);


        // ambil jawaban interview merkea
        // foreach($applicant as $a){
        //     $ans[$a->id]=Answer::with('question')->where('applicant_id',$a->id)->get();
        // }

        $i = 0;        
        foreach($applicant as $a){
            $temp = [];
            $temp['no'] = $i+1;
            $temp['id'] = $a->id;
            $temp['nrp'] = $a->getNRP();
            $temp['name'] = $a->name;
            $temp['prioritas1'] = $a->priorityDivision1->name;
            $temp['prioritas1_id'] = $a->priorityDivision1->id;
            $temp['prioritas2'] = $a->priorityDivision2->name;
            $temp['prioritas2_id'] = $a->priorityDivision2->id;
            $temp['divisi'] = $a->divisionAccepted;
            $temp['email'] = $a->email;
            $temp['gender'] = $a->gender == 0? 'Laki-laki' : 'Perempuan';
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
            if($a->acceptance_stage == 2){
                // diterima prioritas1
                $temp['action1'] = "<div class='text-center w-full '> 
                    <i class='fa-regular fa-circle-check fa-lg' style='color: #16a34a;'></i>        
                </div>
                <h1 class='text-green-600 font-bold text-center'>Accepted</h1>";
            }
            else if($a->acceptance_stage == 3){
                // ditolak prioritas1
                $temp['action1'] = "<div class='text-center w-full '> 
                <i class=' fa-sharp fa-regular fa-circle-xmark fa-lg' style='color: #dc2626;'></i>
                </div>
                <h1 class='text-red-600 font-bold text-center'>Tertolak</h1>";
            }
            else if($a->acceptance_stage == 4){
                // diterima prioritas 2
                $temp['action1'] = "<div class='text-center w-full '> 
                <i class=' fa-sharp fa-regular fa-circle-xmark fa-lg' style='color: #dc2626;'></i>
                </div>
                <h1 class='text-red-600 font-bold text-center'>Tertolak</h1>";

                $temp['action2'] = "<div class='text-center w-full '> 
                <i class='fa-regular fa-circle-check fa-lg' style='color: #16a34a;'></i>        
            </div>
            <h1 class='text-green-600 font-bold text-center'>Accepted</h1>";

            }else if($a->acceptance_stage == 5){
                // ditolak prioritas 2
                $temp['action1'] = "<div class='text-center w-full '> 
                <i class=' fa-sharp fa-regular fa-circle-xmark fa-lg' style='color: #dc2626;'></i>
                </div>
                <h1 class='text-red-600 font-bold text-center'>Tertolak</h1>";

                $temp['action2'] = "<div class='text-center w-full '> 
                <i class=' fa-sharp fa-regular fa-circle-xmark fa-lg' style='color: #dc2626;'></i>
                </div>
                <h1 class='text-red-600 font-bold text-center'>Tertolak</h1>";
            }else if($a->acceptance_stage == 6){
                // terculik
                $temp['action1'] = "<div class='text-center w-full '> 
                <i class='fa-solid fa-circle-info fa-lg' style='color: #fb923c;'></i>   
                </div>
                <h1 class='text-orange-500 font-bold text-center'>Terculik </h1>";

                $temp['action2'] = $temp['action1'];
            }
            $data['applicant'][] = $temp;
            $i++;

        }
        $data['applicant'] = json_encode($data['applicant']);
        

        return view('admin.tolak_terima.tolakTerima', $data);
    }

    public function terima(Request $request){
        $data = $request->only(['id','priority']);
        $applicant = $this->getById($data['id']);
        // $admin_division = Division::where('id',session('division_id'))->first();
        // $admin_division = Division::where('id',"9b09ab7b-aa6c-4867-8312-7c900bd215ea")->first(); //acara
        $admin_division = Division::where('id',"9b09ab7b-ad23-426e-9776-82e196c13581")->first(); //infor
        // $admin_division = Division::where('id',"9b09ab7b-a979-4581-a4c5-b5d7ae3b0b2a")->first(); //bph

        
        // check acceptance stage
        if($data['priority'] == 1){
            // check apakah punya kuasa
            if($admin_division->id != $applicant->priorityDivision1->id && $admin_division->slug != "bph"){
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki kuasa untuk menerima pilihan 1']);
            }

            // terima prioritas 1
            if($applicant->acceptance_stage == 1){
                $this->updatePartial(['acceptance_stage' => 2, 'division_accepted' => $applicant->priorityDivision1->id ],$data['id']);
                return response()->json(['success' => true, 'message' => 'Berhasil menerima anak di pilihan 1']);
            }
    
        }
        
        if($data['priority'] == 2){
            // check apakah punya kuasa
            if($admin_division->id != $applicant->priorityDivision2->id && $admin_division->slug != "bph"){
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki kuasa untuk menerima pilihan 2']);
            }

            if($applicant->acceptance_stage == 3){
                $this->updatePartial(['acceptance_stage' => 4, 'division_accepted' => $applicant->priorityDivision2->id ],$data['id']);
                return response()->json(['success' => true, 'message' => 'Berhasil menerima anak di pilihan 2']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Gagal menerima anak']);
    }

    public function tolak(Request $request){
        $data = $request->only(['id','priority']);
        $applicant = $this->getById($data['id']);
        // $admin_division = Division::where('id',session('division_id'))->first();
        // $admin_division = Division::where('id',"9b09ab7b-aa6c-4867-8312-7c900bd215ea")->first(); //acara
        $admin_division = Division::where('id',"9b09ab7b-ad23-426e-9776-82e196c13581")->first(); //infor
        // $admin_division = Division::where('id',"9b09ab7b-a979-4581-a4c5-b5d7ae3b0b2a")->first(); //bph

        // check acceptance stage
        if($data['priority'] == 1){
            // check apakah punya kuasa
            if($admin_division->id != $applicant->priorityDivision1->id && $admin_division->slug != "bph"){
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki kuasa untuk menolak pilihan 1']);
            }

            // terima prioritas 1
            if($applicant->acceptance_stage == 1){
                $this->updatePartial(['acceptance_stage' => 3],$data['id']);
                return response()->json(['success' => true, 'message' => 'Berhasil menolak anak di pilihan 1']);
            }
        }
        
        if($data['priority'] == 2){
            // check apakah punya kuasa
            if($admin_division->id != $applicant->priorityDivision2->id && $admin_division->slug != "bph"){
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki kuasa untuk menolak pilihan 2']);
            }

            if($applicant->acceptance_stage == 3){
                $this->updatePartial(['acceptance_stage' => 5],$data['id']);
                return response()->json(['success' => true, 'message' => 'Berhasil menolak anak di pilihan 2']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Gagal menolak anak']);
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
