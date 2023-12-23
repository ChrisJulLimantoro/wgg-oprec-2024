<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Date;

class DateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('dates')->truncate();
        Schema::enableForeignKeyConstraints();
        $date = [
            [
                "date" => "2024-02-06",
            ],
            [
                "date" => "2024-02-07"
            ],
            [
                "date" => "2024-02-08"
            ],
            [
                "date" => "2024-02-09"
            ]
        ];
        foreach($date as $date){
            Date::create($date);
        }
    }
}
