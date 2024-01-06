<?php

namespace App\Events;

use App\Models\Applicant;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AllApplicantDocumentsUploaded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Applicant $applicant;
    public int $nextStage;

    /**
     * Create a new event instance.
     */
    public function __construct(Applicant $applicant, int $nextStage)
    {
        $this->applicant = $applicant;
        $this->nextStage = $nextStage;
    }
}
