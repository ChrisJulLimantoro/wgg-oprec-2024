<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Admin;
use App\Models\Schedule;
use App\Models\Date;
use App\Models\Applicant;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('schedules')->truncate();
        Schema::enableForeignKeyConstraints();
        $schedules = [
            'date_id' => Date::get()->first()->id,
            'time' => 8,
            'status' => 2,
            'admin_id' => Admin::get()->first()->id,
            'applicant_id' => Applicant::get()->first()->id,
            'type' => 0,
        ];
        Schedule::create($schedules);
    }
}
