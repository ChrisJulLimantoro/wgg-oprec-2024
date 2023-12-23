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
        session(['admin_id' => '9aea54db-6b09-413f-bcc9-c53a61080c26']);
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
}