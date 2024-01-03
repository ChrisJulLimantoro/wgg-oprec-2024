<?php

namespace App\Events;

use App\Models\Applicant;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicantDocumentsUploaded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Applicant $applicant;
    public int $nextStage;
    public array $allDocuments;

    /**
     * Create a new event instance.
     */
    public function __construct($applicant, $nextStage, $allDocuments)
    {
        $this->applicant = $applicant;
        $this->nextStage = $nextStage;
        $this->allDocuments = $allDocuments;
    }
}
