<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Schedule;
use App\Models\Date;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\DateController;
use Carbon\Carbon;
use DateTime;

class ScheduleController extends BaseController
{
    private $dateController;
    public function __construct(Schedule $model)
    {
        parent::__construct($model);
        $this->dateController = new DateController(new Date());
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */
    public function index(){
        session(['admin_id' => Admin::get()->first()->id ]);
        $date = $this->dateController->getOrderedDates()->toArray();
        $data['title'] = 'Pilih Jadwal';
        $schedule = $this->getSelectedColumn(['*'], ['admin_id' => session('admin_id')])->toArray();
        foreach($date as $d){
            $arr = [];
            $arr['id'] = $d['id'];
            $arr['date'] = $d['date'];
            $arr['day'] = Carbon::createFromFormat('Y-m-d', $d['date'])->format('l');
            foreach($schedule as $s){
                $arrS = [];
                if($s['date_id'] == $d['id']){
                    $arrS['schedule_id'] = $s['id'];
                    $arrS['time'] = $s['time'];
                    $arrS['status'] = $s['status'];
                    $arr['schedules'][] = $arrS;
                }
            }
            if(!isset($arr['schedules'])) $arr['schedules'] = [];
            $data['dates'][] = $arr;
        }
        // dd($data);
        return view('admin.schedule.select',$data);
    }

    public function select(Request $request){
        $schedules = $this->getSelectedColumn(['*'], ['admin_id' => session('admin_id')])->toArray();
        $data = $request->only(['date_id','status','time']);
        if($data['status'] < 0 && $data['status'] > 2) return response()->json(['success' => false, 'message' => 'Status tidak valid'],500);
        $status = $data['status'] == 0 ? 1 : 0;
        $exist = false;
        foreach($schedules as $s){
            if($s['date_id'] == $data['date_id'] && $s['time'] == $data['time']){
                $id = $s['id'];
                $this->updatePartial(['status' => $status],$id);
                $exist = true;
                return response()->json(['success' => true, 'message' => 'Berhasil mengubah jadwal'],200);
            }
        }
        if(!$exist){
            // dd("hello");
            $request->merge(['admin_id' => session('admin_id')]);
            $request->merge(['status' => $status]);
            $store = $this->store($request);
            if(isset($store['error'])) return response()->json(['success' => false, 'message' => 'Gagal mengubah jadwal'],500);
            return response()->json(['success' => true, 'message' => 'Berhasil mengubah jadwal'],200);
        }
    }

    public function myInterview(){
        $data['title'] = 'My Interview';
        $interview = $this->getSelectedColumn(['*'], ['admin_id' => session('admin_id'),'status' => 2],['applicant.priorityDivision1','applicant.priorityDivision2','date'])->toArray();
        $data['interview'] = [];
        foreach($interview as $i){
            $temp = [];
            $temp['id'] = $i['id'];
            $dateObj = DateTime::createFromFormat('Y-m-d', $i['date']['date']);
            $temp['date'] = $dateObj->format('l, d M Y');
            if($i['time'] < 9) $temp['time'] = '0'.$i['time'].':00 - 0'.($i['time']+1).':00';
            else if($i['time'] == 9) $temp['time'] = '0'.$i['time'].':00 - '.($i['time']+1).':00';
            else $temp['time'] = $i['time'].':00 - '.($i['time']+1).':00';
            $temp['name'] = $i['applicant']['name'];
            $temp['priorityDivision1'] = $i['applicant']['priority_division1']['name'];
            $temp['priorityDivision2'] = $i['applicant']['priority_division2']['name'];
            $temp['type'] = $i['type'];
            $temp['link'] = route('admin.interview.start',$i['id']);
            $data['interview'][] = $temp;
        }
        $data['interview'] = json_encode($data['interview']);
        // dd($data);
        return view('admin.interview.my',$data);
    }
}