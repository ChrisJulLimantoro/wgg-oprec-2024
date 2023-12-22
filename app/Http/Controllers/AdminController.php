<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Admin;

class AdminController extends BaseController
{
    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */
}