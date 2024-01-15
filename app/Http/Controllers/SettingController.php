<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends BaseController
{
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */

    public function index()
    {
        $setting = $this->model->all()->toArray();
        $data = [
            'title' => 'Setting',
            'settings' => $setting,
        ];
        return view('admin.setting',$data);
    }

    public function settingUpdate(Request $request)
    {
        $data = $request->only(['id']);
        $setting = $this->model->where('id',$data['id'])->first();

        if($setting->value == 1){
            $setting->value = 0;
        }else{
            $setting->value = 1;
        }
        $setting->save();

        return response()->json([
            'success' => true,
            'message' => 'Setting updated successfully',
            'data' => $setting->value,
        ]);
    }
}