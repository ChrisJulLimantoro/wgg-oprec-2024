<?php

namespace App\Http\Controllers;

use App\Mail\countMail;
use App\Jobs\SendMailJob;
use DateTime;
use Exception;
use Carbon\Carbon;
use App\Models\Date;
use App\Models\Division;
use App\Models\Schedule;
use App\Models\Applicant;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\DateController;

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
            if(isset($store['error'])) return response()->json(['success' => false, 'message' => $store['message']],203);
            return response()->json(['success' => true, 'message' => 'Berhasil mengubah jadwal'],200);
        }
    }

    public function myInterview(){
        $data['title'] = 'My Interview';
        $interview = $this->getSelectedColumn(['*'], ['admin_id' => session('admin_id'),'status' => 2],['applicant.priorityDivision1','applicant.priorityDivision2','applicant.major','date','admin'])->toArray();
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
            $temp['nrp'] = substr($i['applicant']['email'],0,9);
            $temp['major'] = $i['applicant']['major']['english_name'];
            $temp['priorityDivision1'] = $i['applicant']['priority_division1']['name'];
            $temp['priorityDivision2'] = $i['applicant']['priority_division2'] ? $i['applicant']['priority_division2']['name'] : '-';
            $temp['type'] = $i['type'];
            $temp['online'] = $i['online'];
            $temp['link'] = route('admin.interview.start',$i['id']);
            $temp['detail'] = route('admin.applicant.detail',$i['applicant_id']);
            $temp['spot'] = $i['admin']['spot'];
            $temp['meet'] = $i['admin']['meet'];
            $data['interview'][] = $temp;
        }
        $data['interview'] = json_encode($data['interview']);

        // dd($data);
        return view('admin.interview.my',$data);
    }

    public function divisionInterview(){
        $data['title'] = 'All Interview';
        if(session('role') == 'bph'){
            $interview = $this->model->where('status',2)->with(['applicant.priorityDivision1','applicant.priorityDivision2','date','admin','applicant.major'])->get()->toArray();
        }else{
            $interview = $this->model->whereHas('applicant',function($q){
                $q->where('priority_division1',session('division_id'))->orWhere('priority_division2',session('division_id'));
            })->where('status',2)->with(['applicant.priorityDivision1','applicant.priorityDivision2','date','admin','applicant.major'])->get()->toArray();
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
            $temp['nrp'] = substr($i['applicant']['email'],0,9);
            $temp['name'] = $i['applicant']['name'];
            $temp['major'] = $i['applicant']['major']['english_name'];
            $temp['priorityDivision1'] = $i['applicant']['priority_division1']['name'];
            $temp['priorityDivision2'] = $i['applicant']['priority_division2'] ? $i['applicant']['priority_division2']['name'] : '-';
            $temp['type'] = $i['type'];
            $temp['online'] = $i['online'];
            $temp['link'] = route('admin.interview.start',$i['id']);
            $temp['interviewer'] = $i['admin']['name'];
            $temp['inter_id'] = $i['admin_id'];
            $temp['detail'] = route('admin.applicant.detail',$i['applicant_id']);
            $temp['spot'] = $i['admin']['spot'];
            $temp['meet'] = $i['admin']['meet'];
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
            $interview = $this->model->where('status',2)->with(['applicant.priorityDivision1','applicant.priorityDivision2','date','admin','applicant.major'])->get()->toArray();
        }else{
            $interview = $this->model->whereHas('applicant',function($q) use ($division){
                $q->where('priority_division1',$division)->orWhere('priority_division2',$division);
            })->where('status',2)->with(['applicant.priorityDivision1','applicant.priorityDivision2','date','admin','applicant.major'])->get()->toArray();
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
            $temp['nrp'] = substr($i['applicant']['email'],0,9);
            $temp['name'] = $i['applicant']['name'];
            $temp['major'] = $i['applicant']['major']['english_name'];
            $temp['priorityDivision1'] = $i['applicant']['priority_division1']['name'];
            $temp['priorityDivision2'] = $i['applicant']['priority_division2'] ? $i['applicant']['priority_division2']['name'] : '-';
            $temp['type'] = $i['type'];
            $temp['online'] = $i['online'];
            $temp['link'] = route('admin.interview.start',$i['id']);
            $temp['interviewer'] = $i['admin']['name'];
            $temp['inter_id'] = $i['admin_id'];
            $temp['detail'] = route('admin.applicant.detail',$i['applicant_id']);
            $temp['spot'] = $i['admin']['spot'];
            $temp['meet'] = $i['admin']['meet'];
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

        $kidnapper = $this->model->where(['date_id' => $date, 'time' => $time, 'admin_id' => session('admin_id')])->get();
        if($kidnapper->count() > 0){
            if($kidnapper->first()->status == 2){
                return response()->json(['success' => false, 'message' => "You already have an interview at that time and date"],203);
            }
            $new = $kidnapper->first()->id;
            $applicant = $schedule->applicant_id;
            $online = $schedule->online;
            $type = $schedule->type;
            // update the old interview
            $this->updatePartial(['status' => 1,'applicant_id' => null, 'type' => 0],$schedule->id);
            // update the new interview
            $newData = $this->updatePartial(['status' => 2,'applicant_id' => $applicant, 'online' => $online, 'type' => $type],$new);
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

    public function myReschedule(){
        $data['title'] = 'My Reschedule';
    
        $interview = Schedule::with(['applicant.priorityDivision1','applicant.priorityDivision2','date', 'applicant.major'])
                        ->where(['admin_id' => session('admin_id'),'status' => 2])
                        ->whereHas('applicant', function ($query){
                            $query->whereNot('reschedule', "00");           //find reschedule applicant
                        })->get()->toArray();

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
            $temp['nrp'] = substr($i['applicant']['email'],0,9);
            $temp['major'] = $i['applicant']['major']['english_name'];
            $temp['priorityDivision1'] = $i['applicant']['priority_division1']['name'];
            $temp['priorityDivision2'] = $i['applicant']['priority_division2'] ? $i['applicant']['priority_division2']['name'] : '-';
            $temp['type'] = $i['type'];
            $temp['online'] = $i['online'];
            $temp['reschedule'] = $i['applicant']['reschedule'][$i['type'] == 2 ? 1 : 0]; //index for reschedule status

            $temp['date_id'] = $i['date']['id'];
            $temp['time_id'] = $i['time'];

            $data['interview'][] = $temp;
        }
        $data['interview'] = json_encode($data['interview']);

        $data['dates'] = Date::select('id', 'date')->where('date', '>', Carbon::now('Asia/Jakarta'))->get()->toArray();
        $data['times'] = range(8, 19);
        // dd($data);
        return view('admin.interview.reschedule',$data);
    }

    public function reschedule(Request $request){
        DB::beginTransaction();

        try{
            $schedule = $this->model->findOrFail($request->schedule_id);
            $applicant_id = $schedule->applicant_id;
            // dd($applicant_id);
            $type = $schedule->type;
            $new_date_id = $request->date_id;
            $new_online = $request->online;
            $new_time = $request->time;
            Date::findOrFail($new_date_id);
            if (!in_array($new_online, range(0, 1))) throw new Exception();
            if (!in_array($new_time, range(8, 19))) throw new Exception();

            //check is it same with old schedule
            if($schedule->date_id == $new_date_id && $schedule->online == $new_online && $schedule->time == $new_time){
                return redirect()->back()->with('error', 'Jadwal baru sama dengan jadwal lama!');
            }
            
            //change online onsite only
            // if($schedule->date_id == $new_date_id && $schedule->online != $new_online && $schedule->time == $new_time){
            //     $schedule->online = $new_online;
            //     $schedule->save();
            //     $this->updateRescheduleStatus($applicant_id, $type, 2);
            //     return redirect()->back()->with('success', 'Jadwal berhasil diubah');
            // }

            // check not clash with applicant schedule
            $applicant_schedule = $this->model->where(['applicant_id' => $applicant_id, 'date_id' => $new_date_id, 'time' => $new_time])->first();
            if($applicant_schedule){
                return redirect()->back()->with('error', 'Jadwal baru bertabrakan dengan jadwal interview lain Pendaftar!');
            }
            
            //create or update new schedule
            $new_schedule = $this->model->where(['admin_id' => session('admin_id'), 'date_id' => $new_date_id, 'time' => $new_time])->lockForUpdate()->first();
            
            //update new schedule
            if($new_schedule){         
                //check is there any another interview at that time
                if($new_schedule->applicant_id != null || $new_schedule->status != 1){
                    return redirect()->back()->with('error', 'Jadwal baru bertabrakan dengan jadwal interview Anda yang lain!');
                }
                
                $new_schedule->applicant_id = $applicant_id;
                $new_schedule->status = 2;
                $new_schedule->type = $type;
                $new_schedule->online = $new_online;
                $new_schedule->save();
                
            }else{
                //create new schedule
                $new_schedule = $schedule->replicate();
                $new_schedule->date_id = $new_date_id;
                $new_schedule->time = $new_time;
                $new_schedule->online = $new_online;
                $new_schedule->save();

            }

            //set available old schedule
            $schedule->applicant_id = null;
            $schedule->status = 1;
            $schedule->type = 0;
            $schedule->save();
            
            $this->updateRescheduleStatus($applicant_id, $type, 2);
            DB::commit();
            return redirect()->back()->with('success', 'Jadwal berhasil diubah');

        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan! Silahkan coba lagi');
        }
        
        return redirect()->back()->with('error', 'Terjadi kesalahan! Silahkan coba lagi');
    }

    public function updateRescheduleStatus($applicant_id, $type, $status){
        $applicant = Applicant::findOrFail($applicant_id);

        $reschedule_status = $applicant->reschedule;
        $index = $type == 2 ? 1 : 0;    //index for reschedule status to update
        
        $applicant->reschedule = $index == 0 ? $status . $reschedule_status[1] : $reschedule_status[0] . $status;
        $applicant->save();
    }

    public function countSchedule(){
        $date = Date::select('id', 'date')->where('date', '>', Carbon::now('Asia/Jakarta'))->get()->pluck('id')->toArray();
        $data = Schedule::with(['admin.division'])->where('status','1')->whereIn('date_id',$date)->get()->pluck('admin.division.slug')->toArray();
        $division = array_fill_keys(Division::where('slug','!=','open')->where('slug','!=','close')->get()->pluck('slug')->toArray(),0);
        foreach ($data as $d){
            $division[$d] += 1;
        }
        return $division;
    }

    public function mailCount($secret){
        $setting = Setting::where('key','schedule warning')->get();
        if($setting->first()->value == 0 || $secret != env('SECRET_LOGIN')){
            abort(404);
        }
        $coordinator = [
            'it' => [
                'email' => 'c14220061@john.petra.ac.id',
                'name' => 'Ebet',
            ],
            'bph' => [
                'email' => 'd11210185@john.petra.ac.id',
                'name' => 'Everson',
            ],
            'acara' => [
                'email' => 'd11220093@john.petra.ac.id',
                'name' => 'Marcel',
            ],
            'creative' => [
                'email' => 'b11210011@john.petra.ac.id',
                'name' => 'Nathken',
            ],
            'perkap' => [
                'email' => 'd11210178@john.petra.ac.id',
                'name' => 'Liem',
            ],
            'regul' => [
                'email' => 'f11210005@john.petra.ac.id',
                'name' => 'Emanuel',
            ],
            'sekret' => [
                'email' => 'a11220010@john.petra.ac.id',
                'name' => 'Monica',
            ],
            'konsum' => [
                'email' => 'd11220344@john.petra.ac.id',
                'name' => 'Kezia',
            ],
            'kesehatan' => [
                'email' => 'c14220133@john.petra.ac.id',
                'name' => 'Cathlyn',
            ],
            'peran' => [
                'email' => 'd11210058@john.petra.ac.id',
                'name' => 'Fena',
            ]
        ];

        $count = $this->countSchedule();
        foreach($count as $d => $c){
            if($c <= 80){
                $mail = new MailController( new countMail([
                    'slug' => $d,
                    'email' => $coordinator[$d]['email'],
                    'name' => $coordinator[$d]['name'],
                    'count' => $c,
                ]));
                $data['to'] = $coordinator[$d]['email'];
                dispatch(new SendMailJob($mail,$data));
            }
        }
    }
}