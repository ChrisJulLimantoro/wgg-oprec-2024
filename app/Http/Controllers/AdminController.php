<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Admin;
use App\Models\Applicant;

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

    public function applicantCV(Applicant $applicant)
    {
        if ($applicant->stage < 2) {
            return 'Pendaftar masih belum mengupload berkas';
        }

        $cv = $applicant->cv();
        return $cv->stream('CV_' . $applicant->getNRP() . '.pdf');
    }
}
