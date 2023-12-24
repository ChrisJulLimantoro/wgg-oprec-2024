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
        $this->call(DateSeeder::class);
        $this->call(DivisionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(ApplicantSeeder::class);
    }
}
