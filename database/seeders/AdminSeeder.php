<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Admin;
use App\Models\Division;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('admins')->truncate();
        Schema::enableForeignKeyConstraints();
        $admins = [
            [
                "name" => "Christopher Julius Limantoro",
                "email" => "c14210073@john.petra.ac.id",
                "line" => "chrisjul06",
                "division_id" => Division::where('slug', 'it')->first()->id,
            ],
        ];
        foreach($admins as $admin){
            Admin::create($admin);
        }
    }
}
