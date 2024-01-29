<?php

namespace Tests\Feature;

use App\Models\Applicant;
use Tests\TestCase;

class MedicalHistoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_applicant_medical_history(): void
    {
        $applicant = Applicant::get()->first();

        $this->assertArrayHasKey('other_disease', $applicant->medical_history);
        $this->assertArrayHasKey('disease_explanation', $applicant->medical_history);
        $this->assertArrayHasKey('medication_allergy', $applicant->medical_history);
    }

    public function test_applicant_disease(): void
    {
        $applicant = Applicant::get()->first();
        $diseases = $applicant->diseases->toArray();

        $this->assertIsArray($diseases);
        $this->assertArrayHasKey('name', $diseases[0]);
    }
}
