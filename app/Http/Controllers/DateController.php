<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Date;

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
}