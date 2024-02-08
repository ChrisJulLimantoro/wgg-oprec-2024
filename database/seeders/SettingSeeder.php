<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'Active',
                'value' => 1,
                'description' => 'Settings to activate or deactivate the Applicant Registration feature'
            ],
            [
                'key' => 'Email',
                'value' => 1,
                'description' => 'This will send an email to the applicant after they have successfully registered'
            ],
            [
                'key' => 'BPH',
                'value' => 1,
                'description' => 'BPH bisa interview semua divisi (1) atau peran saja (0)'
            ],
            [
                'key' => 'schedule warning',
                'value' => 1,
                'description' => 'Warning if the schedule available count is lower than 20'
            ]
        ];
        foreach($settings as $setting){
            Setting::create($setting);
        }
    }
}
