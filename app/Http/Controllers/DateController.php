<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Date;
use Carbon\Carbon;

class DateController extends BaseController
{
    public function __construct(Date $model)
    {
        parent::__construct($model);
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */
    public function getOrderedDates(){
        return $this->model->orderBy('date','asc')->get();
    }
    public function index()
    {
        $date = $this->getOrderedDates()->toArray();
        $data['title'] = 'Dates';
        $data['dates'] = [];
        foreach($date as $d){
            $arr['id'] = $d['id'];
            $arr['date'] = $d['date'];
            $arr['day'] = Carbon::createFromFormat('Y-m-d', $d['date'])->format('l');
            $data['dates'][] = $arr;
        }

        // dd($data);
        return view('admin.schedule.date',$data);
    }

    public function add(Request $request){
        try{
            $data = $this->store($request);
        }catch(\Exception $e){
            return response()->json(['msg' => $e->getMessage(),'status' => 500],500);
        }
        return response()->json(['msg' => 'Successfully inserted new Date!','status' => 200],200);
    }

    public function destroy($id){
        $data = $this->delete($id);
        if(isset($data['error'])){
            return response()->json(['msg' => $data['error'],'status' => 500],500);
        }else{
            return response()->json(['msg' => 'Successfully deleted Date!','status' => 200],200);
        }
    }
}