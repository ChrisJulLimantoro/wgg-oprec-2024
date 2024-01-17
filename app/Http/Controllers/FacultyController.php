<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Faculty;

class FacultyController extends BaseController
{
    public function __construct(Faculty $model)
    {
        parent::__construct($model);
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */
}