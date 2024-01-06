<?php

namespace App\Listeners;

class UpdateApplicationStage
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $applicant = $event->applicant;
        $applicant->stage = $event->nextStage;
        $applicant->save();
    }
}
