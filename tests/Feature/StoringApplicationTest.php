<?php

namespace Tests\Feature;

use App\Models\Applicant;
use App\Models\Disease;
use App\Models\Division;
use App\Models\Faculty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;


class StoringApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->refreshDatabase();
    }

    /**
     * A basic feature test example.
     */
    public function test_storing_application(): void
    {
        $body = [
            'name' => 'test',
            'email' => 'c14210089@john.petra.ac.id',
            'major_id' => Faculty::where('code', 'C')->first()->majors->first()->id,
            'gender' => 0,
            'religion' => 'Kristen',
            'postal_code' => '60189',
            'birthplace' => 'Surabaya',
            'birthdate' => '2000-01-01',
            'province' => 'Jawa Timur',
            'city' => 'Surabaya',
            'address' => 'Jalan Jalan',
            'phone' => '081234567890',
            'line' => 'lineid',
            'instagram' => 'instagram',
            'tiktok' => null,
            'gpa' => '3.55',
            'motivation' => 'motivation',
            'commitment' => 'commitment',
            'strength' => 'strength',
            'weakness' => 'weakness',
            'experience' => 'experience',
            'diet' => 'Normal',
            'allergy' => 'kacang',
            'medical_history' => [
                'other_disease' => 'other_disease',
                'disease_explanation' => 'disease_explanation',
                'medication_allergy' => 'medication_allergy',
            ],
            'diseases' => Disease::inRandomOrder()->limit(2)->get()->pluck('id')->toArray(),
            'stage' => 1,
            'priority_division1' => Division::first()->id,
            'priority_division2' => null,
            'acceptance_stage' => 1,
            'documents' => null,
            'reschedule' => '00',
        ];
        $response = $this->withSession([
            'email' => 'c14210089@john.petra.ac.id',
            'name' => 'c14210089',
            'nrp' => 'c14210089',
            'isAdmin' => false
        ])
            ->from(route('applicant.application-form'))
            ->post(route('applicant.application.store'), $body);

        $response->assertRedirect(route('applicant.application-form'));
        $response->assertFound();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('applicants', [
            'name' => $body['name'],
            'email' => $body['email'],
            'province' => $body['province'],
            'city' => $body['city'],
        ]);

        $applicantId = Applicant::where('email', $body['email'])->first()->id;
        foreach ($body['diseases'] as $disease) {
            $this->assertDatabaseHas('applicant_disease', [
                'applicant_id' => $applicantId,
                'disease_id' => $disease,
            ]);
        }
    }
}
