<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\Disease;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicantDiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $applicant = Applicant::get()->first();
        $diseases = Disease::inRandomOrder()->limit(3)->get();
        $applicant->diseases()->attach($diseases);
    }
}
