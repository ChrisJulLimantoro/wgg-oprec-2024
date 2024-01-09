<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Admin;
use App\Models\Applicant;
use Illuminate\Http\Request;

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
        }
        if($request->spot){
            $update['spot'] = $request->spot;
        }

        $this->updatePartial($update,$admin);
        return response()->json([
            'success' => true,
            'message' => 'Meeting Spot Updated'
        ],200);
    }
}
