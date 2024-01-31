<?php

namespace App\Listeners;

use App\Events\AllApplicantDocumentsUploaded;

class CheckApplicantDocuments
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $applicant = $event->applicant;
        $applicantDocuments = array_keys($applicant->documents);

        $allDocuments = array_map(function ($document) {
            return strtolower($document);
        }, array_keys($event->allDocuments));

        $remainingDocuments = array_diff($allDocuments, $applicantDocuments);

        if (count($remainingDocuments) === 0) {
            $nextStage = 2;
            if ($applicant->astor) {
                $nextStage = 4;
            }
            AllApplicantDocumentsUploaded::dispatch($applicant, $nextStage);
        }
    }
}
