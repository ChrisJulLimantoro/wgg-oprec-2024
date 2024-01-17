<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Major;

class MajorController extends BaseController
{
    public function __construct(Major $model)
    {
        parent::__construct($model);
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */
}