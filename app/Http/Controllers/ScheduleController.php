<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Schedule;

class ScheduleController extends BaseController
{
    public function __construct(Schedule $model)
    {
        parent::__construct($model);
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */
}