<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = array(
            array('code' => '1', 'name' => 'TEKNIK SIPIL',                                        'english_name' => 'CIVIL ENGINEERING',                                      'faculty_id' => Faculty::where('code', 'B')->first()->id),
            array('code' => '2', 'name' => 'ARSITEKTUR',                                          'english_name' => 'ARCHITECTURE',                                           'faculty_id' => Faculty::where('code', 'B')->first()->id),
            array('code' => '2', 'name' => 'ARCHITECTURE OF SUSTAINABLE HOUSING & REAL ESTATE',   'english_name' => 'ARCHITECTURE OF SUSTAINABLE HOUSING AND REAL ESTATE',    'faculty_id' => Faculty::where('code', 'B')->first()->id),
            array('code' => '1', 'name' => 'TEKNIK ELEKTRO',                                      'english_name' => 'ELECTRICAL ENGINEERING',                                 'faculty_id' => Faculty::where('code', 'C')->first()->id),
            array('code' => '1', 'name' => 'INTERNET OF THINGS',                                  'english_name' => 'INTERNET OF THINGS',                                     'faculty_id' => Faculty::where('code', 'C')->first()->id),
            array('code' => '2', 'name' => 'SUSTAINABLE MECHANICAL ENGINEERING AND DESIGN',       'english_name' => 'SUSTAINABLE MECHANICAL ENGINEERING AND DESIGN',          'faculty_id' => Faculty::where('code', 'C')->first()->id),
            array('code' => '2', 'name' => 'AUTOMOTIVE',                                          'english_name' => 'AUTOMOTIVE',                                             'faculty_id' => Faculty::where('code', 'C')->first()->id),
            array('code' => '3', 'name' => 'TEKNIK INDUSTRI',                                     'english_name' => 'INDUSTRIAL ENGINEERING',                                 'faculty_id' => Faculty::where('code', 'C')->first()->id),
            array('code' => '3', 'name' => 'INTERNATIONAL BUSINESS ENGINEERING',                  'english_name' => 'INTERNATIONAL BUSINESS ENGINEERING',                     'faculty_id' => Faculty::where('code', 'C')->first()->id),
            array('code' => '3', 'name' => 'GLOBAL LOGISTICS & SUPPLY CHAIN',                     'english_name' => 'GLOBAL LOGISTICS AND SUPPLY CHAIN',                      'faculty_id' => Faculty::where('code', 'C')->first()->id),
            array('code' => '4', 'name' => 'INFORMATIKA',                                         'english_name' => 'INFORMATICS',                                          'faculty_id' => Faculty::where('code', 'C')->first()->id),
            array('code' => '4', 'name' => 'SISTEM INFORMASI BISNIS',                             'english_name' => 'BUSINESS INFORMATION SYSTEM',                            'faculty_id' => Faculty::where('code', 'C')->first()->id),
            array('code' => '4', 'name' => 'DATA SCIENCE AND ANALYTICS',                          'english_name' => 'DATA SCIENCE AND ANALYTICS',                             'faculty_id' => Faculty::where('code', 'C')->first()->id),
            array('code' => '1', 'name' => 'CREATIVE TOURISM',                                    'english_name' => 'CREATIVE TOURISM',                                       'faculty_id' => Faculty::where('code', 'D')->first()->id),
            array('code' => '1', 'name' => 'HOTEL MANAGEMENT',                                    'english_name' => 'HOTEL MANAGEMENT',                                       'faculty_id' => Faculty::where('code', 'D')->first()->id),
            array('code' => '1', 'name' => 'FINANCE AND INVESTMENT',                              'english_name' => 'FINANCE AND INVESTMENT',                                 'faculty_id' => Faculty::where('code', 'D')->first()->id),
            array('code' => '1', 'name' => 'BRANDING AND DIGITAL MARKETING',                      'english_name' => 'BRANDING AND DIGITAL MARKETING',                         'faculty_id' => Faculty::where('code', 'D')->first()->id),
            array('code' => '1', 'name' => 'BUSINESS MANAGEMENT',                                 'english_name' => 'BUSINESS MANAGEMENT',                                    'faculty_id' => Faculty::where('code', 'D')->first()->id),
            array('code' => '1', 'name' => 'INTERNATIONAL BUSINESS MANAGEMENT',                   'english_name' => 'INTERNATIONAL BUSINESS MANAGEMENT',                      'faculty_id' => Faculty::where('code', 'D')->first()->id),
            array('code' => '2', 'name' => 'BUSINESS ACCOUNTING',                                 'english_name' => 'BUSINESS ACCOUNTING',                                    'faculty_id' => Faculty::where('code', 'D')->first()->id),
            array('code' => '2', 'name' => 'INTERNATIONAL BUSINESS ACCOUNTING',                   'english_name' => 'INTERNATIONAL BUSINESS ACCOUNTING',                      'faculty_id' => Faculty::where('code', 'D')->first()->id),
            array('code' => '2', 'name' => 'TAX ACCOUNTING',                                      'english_name' => 'TAX ACCOUNTING',                                         'faculty_id' => Faculty::where('code', 'D')->first()->id),
            array('code' => '1', 'name' => 'PENDIDIKAN GURU - SEKOLAH DASAR',                     'english_name' => 'ELEMENTARY TEACHER EDUCATION',                           'faculty_id' => Faculty::where('code', 'G')->first()->id),
            array('code' => '2', 'name' => 'PENDIDIKAN GURU PENDIDIKAN ANAK USIA DINI',           'english_name' => 'EARLY CHILDHOOD TEACHER EDUCATION',                      'faculty_id' => Faculty::where('code', 'G')->first()->id),
            array('code' => '1', 'name' => 'ENGLISH FOR BUSINESS',                                'english_name' => 'ENGLISH FOR BUSINESS',                                   'faculty_id' => Faculty::where('code', 'A')->first()->id),
            array('code' => '1', 'name' => 'ENGLISH FOR CREATIVE INDUSTRY',                       'english_name' => 'ENGLISH FOR CREATIVE INDUSTRY',                          'faculty_id' => Faculty::where('code', 'A')->first()->id),
            array('code' => '2', 'name' => 'BAHASA MANDARIN',                                     'english_name' => 'CHINESE',                                                'faculty_id' => Faculty::where('code', 'A')->first()->id),
            array('code' => '1', 'name' => 'ENGLISH FOR BUSINESS',                                'english_name' => 'ENGLISH FOR BUSINESS',                                   'faculty_id' => Faculty::where('code', 'H')->first()->id),
            array('code' => '1', 'name' => 'ENGLISH FOR CREATIVE INDUSTRY',                       'english_name' => 'ENGLISH FOR CREATIVE INDUSTRY',                          'faculty_id' => Faculty::where('code', 'H')->first()->id),
            array('code' => '2', 'name' => 'BAHASA MANDARIN',                                     'english_name' => 'CHINESE',                                                'faculty_id' => Faculty::where('code', 'H')->first()->id),
            array('code' => '1', 'name' => 'INTERIOR PRODUCT DESIGN',                             'english_name' => 'INTERIOR PRODUCT DESIGN',                                'faculty_id' => Faculty::where('code', 'E')->first()->id),
            array('code' => '1', 'name' => 'INTERIOR DESIGN AND STYLING',                         'english_name' => 'INTERIOR DESIGN AND STYLING',                            'faculty_id' => Faculty::where('code', 'E')->first()->id),
            array('code' => '2', 'name' => 'DESAIN KOMUNIKASI VISUAL',                            'english_name' => 'VISUAL COMMUNICATION DESIGN',                            'faculty_id' => Faculty::where('code', 'E')->first()->id),
            array('code' => '2', 'name' => 'TEXTILE AND FASHION DESIGN',                          'english_name' => 'TEXTILE AND FASHION DESIGN',                             'faculty_id' => Faculty::where('code', 'E')->first()->id),
            array('code' => '2', 'name' => 'INTERNATIONAL PROGRAM IN DIGITAL MEDIA',              'english_name' => 'INTERNATIONAL PROGRAM IN DIGITAL MEDIA',                 'faculty_id' => Faculty::where('code', 'E')->first()->id),
            array('code' => '3', 'name' => 'INTERIOR PRODUCT DESIGN',                             'english_name' => 'INTERIOR PRODUCT DESIGN',                                'faculty_id' => Faculty::where('code', 'H')->first()->id),
            array('code' => '3', 'name' => 'INTERIOR DESIGN AND STYLING',                         'english_name' => 'INTERIOR DESIGN AND STYLING',                            'faculty_id' => Faculty::where('code', 'H')->first()->id),
            array('code' => '4', 'name' => 'DESAIN KOMUNIKASI VISUAL',                            'english_name' => 'VISUAL COMMUNICATION DESIGN',                            'faculty_id' => Faculty::where('code', 'H')->first()->id),
            array('code' => '4', 'name' => 'TEXTILE AND FASHION DESIGN',                          'english_name' => 'TEXTILE AND FASHION DESIGN',                             'faculty_id' => Faculty::where('code', 'H')->first()->id),
            array('code' => '4', 'name' => 'INTERNATIONAL PROGRAM IN DIGITAL MEDIA',              'english_name' => 'INTERNATIONAL PROGRAM IN DIGITAL MEDIA',                 'faculty_id' => Faculty::where('code', 'H')->first()->id),
            array('code' => '5', 'name' => 'BROADCAST AND JOURNALISM',                            'english_name' => 'BROADCAST AND JOURNALISM',                               'faculty_id' => Faculty::where('code', 'F')->first()->id),
            array('code' => '5', 'name' => 'STRATEGIC COMMUNICATION',                             'english_name' => 'STRATEGIC COMMUNICATION',                                'faculty_id' => Faculty::where('code', 'F')->first()->id),
            array('code' => '5', 'name' => 'BROADCAST AND JOURNALISM',                            'english_name' => 'BROADCAST AND JOURNALISM',                               'faculty_id' => Faculty::where('code', 'H')->first()->id),
            array('code' => '5', 'name' => 'STRATEGIC COMMUNICATION',                             'english_name' => 'STRATEGIC COMMUNICATION',                                'faculty_id' => Faculty::where('code', 'H')->first()->id),
        );

        foreach ($majors as $major) {
            \App\Models\Major::create($major);
        }
    }
}
