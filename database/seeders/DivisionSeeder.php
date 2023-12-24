<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('divisions')->truncate();
        Schema::enableForeignKeyConstraints();
        $divisions = [
            [
                "name" => "Badan Pengurus Harian",
                "slug" => "bph"
            ],
            [
                "name" => "Acara",
                "slug" => "acara"
            ],
            [
                "name" => "Creative",
                "slug" => "creative"
            ],
            [
                "name" => "Information Technology",
                "slug" => "it"
            ],
            [
                "name" => "Perlengkapan",
                "slug" => "perkap"
            ],
            [
                "name" => "Regulasi",
                "slug" => "regul"
            ],
            [
                "name" => "Sekretariat",
                "slug" => "sekret"
            ],
            [
                "name" => "Konsumsi",
                "slug" => "konsum"
            ],
            [
                "name" => "Kesehatan",
                "slug" => "kesehatan"
            ],
            [
                "name" => "Peran",
                "slug" => "peran"
            ],
            [
                "name" => "Opening",
                "slug" => "open"
            ],
            [
                "name" => "Closing",
                "slug" => "close"
            ]
        ];
        foreach($divisions as $division){
            Division::create($division);
        }
    }
}
