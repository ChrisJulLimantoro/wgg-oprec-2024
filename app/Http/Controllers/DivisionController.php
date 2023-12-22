<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Division;

class DivisionController extends BaseController
{
    public function __construct(Division $model)
    {
        parent::__construct($model);
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */
}