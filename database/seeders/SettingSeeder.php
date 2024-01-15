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
            ]
        ];
        foreach($settings as $setting){
            Setting::create($setting);
        }
    }
}
