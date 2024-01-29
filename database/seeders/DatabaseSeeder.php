<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DivisionSeeder::class);
        $this->call(DiseaseSeeder::class);
        $this->call(FacultySeeder::class);
        $this->call(MajorSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(DateSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(ApplicantSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(ApplicantDiseaseSeeder::class);
    }
}
