<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Applicant;
use App\Models\Answer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['title'] = "Dashboard";
        $data['divisions'] = Division::whereNotIn('name', ['Badan Pengurus Harian', 'Opening', 'Closing'])
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.dashboard', $data);
    }

    public function getData(Request $request)
    {
        $id = $request->id;
        if ($id == 'all') {
            for ($i = 1; $i < 4; $i++) {
                $data[] = Applicant::where('stage', '>=', $i)->get()->count();
            }
            $data[] = Answer::select('applicant_id')->groupBy('applicant_id')->get()->count();
        } 
        else {
            for ($i = 1; $i < 4; $i++) {
                $data[] = Applicant::where('stage', '>=', $i)
                    ->where(function ($q) use ($id) {   
                        $q->where('priority_division1', $id)
                            ->orWhere('priority_division2', $id);
                    })  
                    ->get()
                    ->count();
            }
            $data[] = Answer::select('applicant_id')
                ->join('applicants', 'applicants.id', '=', 'answers.applicant_id')
                ->where('applicants.priority_division1', $id)
                ->orWhere('applicants.priority_division2', $id)
                ->groupBy('answers.applicant_id')
                ->get()
                ->count();
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
