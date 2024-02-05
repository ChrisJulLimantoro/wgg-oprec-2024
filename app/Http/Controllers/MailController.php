<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

class MailController extends Controller
{
    public $mail;

    public function __construct(Mailable $mail)
    {
        $this->mail = $mail;
    }

    public function determineTarget(string $email)
    {
        return (env("APP_ENV") == "local" ? 'c14210017@john.petra.ac.id' : $email);
    }

    public function sendMail($data)
    {
        return Mail::to($this->determineTarget($data['to']))->send($this->mail);
    }
}
