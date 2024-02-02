<?php

namespace Tests\Feature;

use App\Models\Applicant;
use App\Models\Date;
use App\Models\Disease;
use App\Models\Division;
use App\Models\Faculty;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InterviewScheduleTest extends TestCase
{
    use RefreshDatabase;

    public $seeder = 'DatabaseSeeder';

    public function setUp(): void
    {
        parent::setUp();

        $this->refreshDatabase();

        for ($i = 1; $i < 4; $i++) {
            Date::create([
                'date' => now()->subDays($i)->format('Y-m-d'),
            ]);
        }

        Date::create([
            'date' => now()->format('Y-m-d'),
        ]);

        for ($i = 1; $i < 5; $i++) {
            Date::create([
                'date' => now()->addDays($i)->format('Y-m-d'),
            ]);
        }

        $applicant = [
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
            'astor' => 0,
            'stage' => 2,
            'priority_division1' => Division::first()->id,
            'priority_division2' => null,
            'acceptance_stage' => 1,
            'documents' => null,
            'reschedule' => '00',
        ];

        Applicant::create($applicant);
    }

    /**
     * A basic feature test example.
     */
    public function test_date_option_before_9pm(): void
    {
        $this->travelTo(now()->hours(19)->minutes(10));

        $response = $this->withSession([
            'email' => 'c14210089@john.petra.ac.id',
            'name' => 'c14210089',
            'nrp' => 'c14210089',
            'isAdmin' => false
        ])->get(route('applicant.schedule-form'));

        $dates = $response->viewData('dates');
        echo '----before 7pm----' . PHP_EOL;

        foreach ($dates as $date) {
            echo $date['date'] . PHP_EOL;
            $this->assertGreaterThan(now()->format('Y-m-d'), $date['date']);
        }

        $this->travelBack();
    }

    public function test_date_option_after_9pm(): void
    {
        $this->travelTo(now()->hours(23)->minutes(10));

        $response = $this->withSession([
            'email' => 'c14210089@john.petra.ac.id',
            'name' => 'c14210089',
            'nrp' => 'c14210089',
            'isAdmin' => false
        ])->get(route('applicant.schedule-form'));

        $dates = $response->viewData('dates');
        echo '----after 7pm----' . PHP_EOL;
        foreach ($dates as $date) {
            echo $date['date'] . PHP_EOL;
            $this->assertGreaterThan(Carbon::tomorrow()->format('Y-m-d'), $date['date']);
        }

        $this->travelBack();
    }
}
