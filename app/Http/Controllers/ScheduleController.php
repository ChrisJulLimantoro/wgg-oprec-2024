<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Schedule;
use App\Models\Date;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\DateController;
use Carbon\Carbon;
use App\Models\Division;
use DateTime;

class ScheduleController extends BaseController
{
    private $dateController;
    private $division;
    public function __construct(Schedule $model)
    {
        parent::__construct($model);
        $this->dateController = new DateController(new Date());
        $this->division = new Division();
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */
    public function index(){
        // session(['admin_id' => Admin::get()->first()->id ]);
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
                    $arrS['online'] = $s['online'];
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
        $data = $request->only(['date_id','status','time','online']);
        if($data['status'] < 0 && $data['status'] > 2) return response()->json(['success' => false, 'message' => 'Status tidak valid'],500);
        $status = $data['status'];
        $exist = false;
        foreach($schedules as $s){
            if($s['date_id'] == $data['date_id'] && $s['time'] == $data['time']){
                $id = $s['id'];
                $this->updatePartial(['status' => $status,'online' => $data['online']],$id);
                $exist = true;
                return response()->json(['success' => true, 'message' => 'Berhasil mengubah jadwal'],200);
            }
        }
        if(!$exist){
            // dd("hello");
            $request->merge(['admin_id' => session('admin_id')]);
            $request->merge(['status' => $status]);
            $request->merge(['online' => $data['online']]);
            $store = $this->store($request);
            if(isset($store['error'])) return response()->json(['success' => false, 'message' => 'Gagal mengubah jadwal'],500);
            return response()->json(['success' => true, 'message' => 'Berhasil mengubah jadwal'],200);
        }
    }

    public function myInterview(){
        $data['title'] = 'My Interview';
        // session(['admin_id' => Admin::get()->first()->id ]);
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
            $temp['priorityDivision2'] = $i['applicant']['priority_division2'] ? $i['applicant']['priority_division2']['name'] : '-';
            $temp['type'] = $i['type'];
            $temp['online'] = $i['online'];
            $temp['link'] = route('admin.interview.start',$i['id']);
            $data['interview'][] = $temp;
        }
        $data['interview'] = json_encode($data['interview']);
        // dd($data);
        return view('admin.interview.my',$data);
    }

    public function divisionInterview(){
        $data['title'] = 'My Interview';
        if(session('role') == 'bph'){
            $interview = $this->model->where('status',2)->with(['applicant.priorityDivision1','applicant.priorityDivision2','date','admin'])->get()->toArray();
        }else{
            $interview = $this->model->whereHas('applicant',function($q){
                $q->where('priority_division1',session('division_id'))->orWhere('priority_division2',session('division_id'));
            })->where('status',2)->with(['applicant.priorityDivision1','applicant.priorityDivision2','date','admin'])->get()->toArray();
        }
        // Query
        $data['interview'] = [];
        foreach($interview as $i){
            $temp = [];
            $temp['id'] = $i['id'];
            $dateObj = DateTime::createFromFormat('Y-m-d', $i['date']['date']);
            $temp['date'] = $dateObj->format('l, d M Y');
            if($i['time'] < 9) $temp['time'] = '0'.$i['time'].':00 - 0'.($i['time']+1).':00';
            else if($i['time'] == 9) $temp['time'] = '0'.$i['time'].':00 - '.($i['time']+1).':00';
            else $temp['time'] = $i['time'].':00 - '.($i['time']+1).':00';
            // $temp['date'] = $temp['date'].' '.$temp['time'];
            $temp['name'] = $i['applicant']['name'];
            $temp['priorityDivision1'] = $i['applicant']['priority_division1']['name'];
            $temp['priorityDivision2'] = $i['applicant']['priority_division2'] ? $i['applicant']['priority_division2']['name'] : '-';
            $temp['type'] = $i['type'];
            $temp['online'] = $i['online'];
            $temp['link'] = route('admin.interview.start',$i['id']);
            $temp['interviewer'] = $i['admin']['name'];
            $temp['inter_id'] = $i['admin_id'];
            $data['interview'][] = $temp;
        }
        $data['interview'] = json_encode($data['interview']);

        // Division
        $division = $this->division->get()->toArray();
        // dd($division);
        foreach($division as $d){
            $temp = [];
            if($d['slug'] == 'open' || $d['slug'] == 'close' || $d['slug'] == 'bph') continue;
            $temp['id'] = $d['id'];
            $temp['name'] = $d['name'];
            $data['division'][] = $temp;
        }
        // dd($data);
        return view('admin.interview.all',$data);
    }

    public function scheduleDivision(Request $request)
    {
        $division = $request->division;
        if($division == 'all'){
            $interview = $this->model->where('status',2)->with(['applicant.priorityDivision1','applicant.priorityDivision2','date','admin'])->get()->toArray();
        }else{
            $interview = $this->model->whereHas('applicant',function($q) use ($division){
                $q->where('priority_division1',$division)->orWhere('priority_division2',$division);
            })->where('status',2)->with(['applicant.priorityDivision1','applicant.priorityDivision2','date','admin'])->get()->toArray();
        }
        $data = [];
        foreach($interview as $i){
            $temp = [];
            $temp['id'] = $i['id'];
            $dateObj = DateTime::createFromFormat('Y-m-d', $i['date']['date']);
            $temp['date'] = $dateObj->format('l, d M Y');
            if($i['time'] < 9) $temp['time'] = '0'.$i['time'].':00 - 0'.($i['time']+1).':00';
            else if($i['time'] == 9) $temp['time'] = '0'.$i['time'].':00 - '.($i['time']+1).':00';
            else $temp['time'] = $i['time'].':00 - '.($i['time']+1).':00';
            // $temp['date'] = $temp['date'].' '.$temp['time'];
            $temp['name'] = $i['applicant']['name'];
            $temp['priorityDivision1'] = $i['applicant']['priority_division1']['name'];
            $temp['priorityDivision2'] = $i['applicant']['priority_division2'] ? $i['applicant']['priority_division2']['name'] : '-';
            $temp['type'] = $i['type'];
            $temp['online'] = $i['online'];
            $temp['link'] = route('admin.interview.start',$i['id']);
            $temp['interviewer'] = $i['admin']['name'];
            $temp['inter_id'] = $i['admin_id'];
            $data[] = $temp;
        }
        return response()->json(['success' => true, 'data' => $data],200);
    }

    public function kidnap(Request $request){
        // dd($request->schedule_id);
        $schedule = $this->getById($request->schedule_id);
        // dd($schedule);
        // check for yourself
        if($schedule->admin_id == session('admin_id')){
            return response()->json(['success' => false, 'message' => "It's already yours"],500);
        }

        // date time interviewe
        $date = $schedule->date_id;
        $time = $schedule->time;

        $kidnapper = $this->model->where(['date_id' => $date, 'time' => $time, 'admin_id' => session('admin')])->get();

        if($kidnapper->count() > 0){
            if($kidnapper->first()->status == 2){
                return response()->json(['success' => false, 'message' => "You already have an interview at that time and date"],500);
            }
            $new = $kidnapper->first()->id;
            // update the new interview
            $newData = $this->updatePartial(['status' => 2,'applicant_id' => $schedule->applicant_id, 'online' => $schedule->online, 'type' => $schedule->type],$new);
            // update the old interview
            $this->updatePartial(['status' => 1,'applicant_id' => null, 'type' => 0],$schedule->id);
        }else{
            // create new interview
            $newData = $this->model->create([
                'date_id' => $date,
                'time' => $time,
                'admin_id' => session('admin_id'),
                'status' => 2,
                'applicant_id' => $schedule->applicant_id,
                'online' => $schedule->online,
                'type' => $schedule->type
            ]);
            // update the old interview
            $this->updatePartial(['status' => 1,'applicant_id' => null, 'type' => 0],$schedule->id);
        }
        return response()->json(['success' => true, 'message' => 'Berhasil menculik jadwal interview','data' => $newData],200);
    }
}