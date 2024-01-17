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
        $applicant = Applicant::all()->toArray();
        $time = 8;
        foreach($applicant as $a){
            $schedules[] = [
                'date_id' => Date::get()->first()->id,
                'time' => $time++,
                'status' => 2,
                'admin_id' => Admin::get()->first()->id,
                'applicant_id' => $a['id'],
                'type' => 0,
                'online' => 0
            ];
        }
        foreach($schedules as $s){
            Schedule::create($s);
        }
    }
}
