<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Question;
use App\Models\Division;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('questions')->truncate();
        Schema::enableForeignKeyConstraints();
        $questions = [
            [
                'question' => 'Apa yang kamu ketahui tentang WGG?',
                'division_id' => Division::where('slug', 'open')->first()->id,
                'description' => 'Seberapa memahami wgg'
            ],
            [
                'question' => 'Apa yang kamu ketahui tentang tema WGG 2024?',
                'division_id' => Division::where('slug', 'open')->first()->id,
                'description' => 'Seberapa memahami wgg 2024'
            ],
            [
                'question' => 'Apa yang kamu ketahui tentang Divisi IT?',
                'division_id' => Division::where('slug', 'it')->first()->id,
                'description' => 'Seberapa memahami divisi IT'
            ],
            [
                'question' => 'Apa yang kamu ketahui tentang Divisi Acara?',
                'division_id' => Division::where('slug', 'acara')->first()->id,
                'description' => 'Seberapa memahami divisi acara'
            ],
            [
                'question' => 'Apa yang kamu ketahui tentang Divisi Creative?',
                'division_id' => Division::where('slug', 'creative')->first()->id,
                'description' => 'Seberapa memahami divisi creative'
            ],
            [
                'question' => 'Apa yang kamu ketahui tentang Divisi Perlengkapan?',
                'division_id' => Division::where('slug', 'perkap')->first()->id,
                'description' => 'Seberapa memahami divisi perlengkapan'
            ],
            [
                'question' => 'Apa yang kamu ketahui tentang Divisi Regulasi?',
                'division_id' => Division::where('slug', 'regul')->first()->id,
                'description' => 'Seberapa memahami divisi regulasi'
            ],
            [
                'question' => 'Apa yang kamu ketahui tentang Divisi Sekretariat?',
                'division_id' => Division::where('slug', 'sekret')->first()->id,
                'description' => 'Seberapa memahami divisi sekretariat'
            ],
            [
                'question' => 'Apa yang kamu ketahui tentang Divisi Konsumsi?',
                'division_id' => Division::where('slug', 'konsum')->first()->id,
                'description' => 'Seberapa memahami divisi konsumsi'
            ],
            [
                'question' => 'Apa yang kamu ketahui tentang Divisi Kesehatan?',
                'division_id' => Division::where('slug', 'kesehatan')->first()->id,
                'description' => 'Seberapa memahami divisi kesehatan'
            ],
            [
                'question' => 'Apa yang kamu ketahui tentang Divisi Peran?',
                'division_id' => Division::where('slug', 'peran')->first()->id,
                'description' => 'Seberapa memahami divisi peran'
            ],
            [
                'question' => 'Terima kasih',
                'division_id' => Division::where('slug', 'close')->first()->id,
                'description' => 'Seberapa memahami terima kasih',
            ]
        ];
        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
