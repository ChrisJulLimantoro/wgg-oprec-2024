<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Admin;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Disease;

class AdminController extends BaseController
{
    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */

    public function applicantCV(Applicant $applicant)
    {
        if ($applicant->stage < 2) {
            return 'Pendaftar masih belum mengupload berkas';
        }
        $applicant->load($applicant->relations());
        $cv = $applicant->cv();
        return $cv->stream('CV_' . $applicant->getNRP() . '.pdf');
    }
    
    public function meetingSpot(){
        $admin = $this->getById(session('admin_id'))->toArray();
        $data['title'] = 'Meeting Spot';
        $data['admin'] = $admin;
        // dd($data);
        return view('admin.meeting-spot',$data);
    }

    public function updateMeetSpot($admin,Request $request){
        $update = [];
        if($request->meet){
            $update['meet'] = $request->meet;
            $valid = Validator::make($request->only(['meet']),[
                'meet' => 'required|url:https,http'
            ],[
                'meet.required' => 'Meeting Link is required',
                'meet.url' => 'Meeting Link must be a valid URL'
            ]);
            if($valid->fails()){
                // dd($valid->errors()->first());
                return response()->json([
                    'success' => false,
                    'message' => $valid->errors()->first()
                ],200);
            }
        }
        if($request->spot){
            $update['spot'] = $request->spot;
        }

        if($request->line){
            $update['line'] = $request->line;
        }

        $this->updatePartial($update,$admin);
        return response()->json([
            'success' => true,
            'message' => 'Data Updated'
        ],200);
    }

    public function medicalForm(){
        $admin = $this->getById(session('admin_id'))->toArray();
        $data['title'] = 'Medical Form';
        $data['diseases'] = Disease::all(['id', 'name'])->toArray();
        $data['admin'] = $admin;
        // dd($data);
        return view('admin.medical',$data);
    }

    public function updateMedicalHistory(Admin $admin,Request $request){
        $update = $request->only(['medical_history','diseases']);
        // dd($update);
        $valid = Validator::make($update,[
            'medical_history' => 'required|required_array_keys:other_disease,disease_explanation,medication_allergy',
            'medical_history.other_disease' => 'required|string|min:1',
            'medical_history.disease_explanation' => 'required|string|min:1',
            'medical_history.medication_allergy' => 'required|string|min:1',
            'diseases' => 'array|exists:diseases,id'
        ],[
            'medical_history.required' => 'Medical History is required',
            'medical_history.required_array_keys' => 'Medical History must be an array with keys other_disease,disease_explanation,medication_allergy',
            'medical_history.other_disease.required' => 'Other Disease is required',
            'medical_history.other_disease.string' => 'Other Disease must be a string',
            'medical_history.other_disease.min' => 'Other Disease must be at least 1 character',
            'medical_history.disease_explanation.required' => 'Disease Explanation is required',
            'medical_history.disease_explanation.string' => 'Disease Explanation must be a string',
            'medical_history.disease_explanation.min' => 'Disease Explanation must be at least 1 character',
            'medical_history.medication_allergy.required' => 'Medication Allergy is required',
            'medical_history.medication_allergy.string' => 'Medication Allergy must be a string',
            'medical_history.medication_allergy.min' => 'Medication Allergy must be at least 1 character',
            'diseases.array' => 'Diseases must be an array',
            'diseases.exists' => 'Diseases must be exists',
        ]);

        if($valid->fails()){
            return redirect()->back()->withErrors($valid)->withInput();
        }
        // update relations Data
        $this->updatePartial([
            'medical_history' => $update['medical_history']
        ],$admin->id);

        if(isset($request->diseases)){
            // Remove all old diseases
            $admin->resetDiseases();
            // Add new diseases
            $admin->addDiseases($request->diseases);
        }

        return redirect()->back()->with('success','Medical History Updated');
    }
}
