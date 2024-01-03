<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Schedule;
use App\Models\Date;
use Illuminate\Http\Request;
use App\Http\Controllers\DateController;
use Carbon\Carbon;

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
        session(['admin_id' => '9aec71b3-88d8-442d-89b4-7f57bd30384d']);
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
                $this->update($id,['status' => $status]);
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
        $data['interview'] = $this->getSelectedColumn(['*'], ['admin_id' => session('admin_id'),'status' => 2])->toArray();

        return view('admin.interview.my',$data);
    }
}