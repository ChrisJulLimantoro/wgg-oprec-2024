<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = array(
            array('code' => 'A', 'name' => 'FAKULTAS BAHASA DAN SASTRA',              'english_name' => null),
            array('code' => 'B', 'name' => 'FAKULTAS TEKNIK SIPIL DAN PERENCANAAN',   'english_name' => 'FACULTY OF CIVIL ENGINEERING AND PLANNING'),
            array('code' => 'C', 'name' => 'FAKULTAS TEKNOLOGI INDUSTRI',             'english_name' => 'FACULTY OF INDUSTRIAL TECHNOLOGY'),
            array('code' => 'D', 'name' => 'FAKULTAS BISNIS DAN EKONOMI',             'english_name' => 'SCHOOL OF BUSINESS AND MANAGEMENT'),
            array('code' => 'E', 'name' => 'FAKULTAS SENI DAN DESAIN',                'english_name' => null),
            array('code' => 'F', 'name' => 'FAKULTAS ILMU KOMUNIKASI',                'english_name' => null),
            array('code' => 'G', 'name' => 'FAKULTAS KEGURUAN AND ILMU PENDIDIKAN',   'english_name' => 'FACULTY OF TEACHER EDUCATION'),
            array('code' => 'H', 'name' => 'FAKULTAS HUMANIORA DAN INDUSTRI KREATIF', 'english_name' => 'FACULTY OF HUMANITIES AND CREATIVE INDUSTRIES'),
        );

        foreach ($faculties as $faculty) {
            \App\Models\Faculty::create($faculty);
        }
    }
}
