<?php

namespace App\Http\Controllers;

use App\Mail\scheduleMail;
use App\Models\Applicant;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{

    public function __construct()
    {
        // $this->applicant = new Applicant();
    }

    public static function sendInterviewSchedule($data) {
        // dd($data);
        $mail = new scheduleMail($data);
        // $succ = Mail::to($data['applicant']['email'])->send($mail);
        $succ = Mail::to('c14210017@john.petra.ac.id')->send($mail);


        if ($succ != null) {
            return true;
        } else {
            return false;
        }
    }
}
