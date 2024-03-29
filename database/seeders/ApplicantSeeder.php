<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Applicant;
use App\Models\Division;
use App\Models\Major;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('applicants')->truncate();
        Schema::enableForeignKeyConstraints();
        $applicants = [
            [
                'name' => 'Leonardo Nickholas',
                'email' => 'c14210206@john.petra.ac.id',
                'major_id' => Major::where('name', 'SISTEM INFORMASI BISNIS')->first()->id,
                'gender' => 0,
                'religion' => 'Kristen',
                'birthplace' => 'Surabaya',
                'birthdate' => '2003-08-14',
                'address' => 'Jl. Raya Darmo Permai III/1',
                'province' => 'Jawa Timur',
                'city' => 'Surabaya',
                'postal_code' => '60189',
                'line' => 'leonickh',
                'phone' => '081234567890',
                'instagram' => 'leonickh',
                'tiktok' => 'leonickh',
                'gpa' => '3.95',
                'motivation' => 'Saya ingin mengembangkan diri saya',
                'commitment' => 'Saya akan berkomitmen untuk mengikuti kegiatan WGG',
                'strength' => 'Saya memiliki kekuatan untuk mengikuti kegiatan WGG',
                'weakness' => 'Saya memiliki kelemahan untuk mengikuti kegiatan WGG',
                'experience' => 'Saya memiliki pengalaman untuk mengikuti kegiatan WGG',
                'diet' => 'Tidak ada',
                'allergy' => 'Tidak ada',
                'medical_history' => [
                    'other_disease' => '-',
                    'disease_explanation' => '-',
                    'medication_allergy' => '-',
                ],
                'astor' => 0,
                'priority_division1' => Division::where('slug', 'it')->first()->id,
                'priority_division2' => Division::where('slug', 'acara')->first()->id,
                'division_accepted' => null,
                'stage' => 4,
            ],
            [
                'name' => 'Nicholas Gunawan',
                'email' => 'c14210098@john.petra.ac.id',
                'major_id' => Major::where('name', 'DATA SCIENCE AND ANALYTICS')->first()->id,
                'gender' => 0,
                'religion' => 'Kristen',
                'birthplace' => 'Surabaya',
                'birthdate' => '2003-08-14',
                'address' => 'Jl. Raya Darmo Permai III/1',
                'province' => 'Jawa Timur',
                'city' => 'Surabaya',
                'postal_code' => '60189',
                'line' => 'leonickh',
                'phone' => '081234567890',
                'instagram' => 'leonickh',
                'tiktok' => 'leonickh',
                'gpa' => '3.95',
                'motivation' => 'Saya ingin mengembangkan diri saya',
                'commitment' => 'Saya akan berkomitmen untuk mengikuti kegiatan WGG',
                'strength' => 'Saya memiliki kekuatan untuk mengikuti kegiatan WGG',
                'weakness' => 'Saya memiliki kelemahan untuk mengikuti kegiatan WGG',
                'experience' => 'Saya memiliki pengalaman untuk mengikuti kegiatan WGG',
                'diet' => 'Tidak ada',
                'allergy' => 'Tidak ada',
                'medical_history' => [
                    'other_disease' => '-',
                    'disease_explanation' => '-',
                    'medication_allergy' => '-',
                ],
                'astor' => 0,
                'priority_division1' => Division::where('slug', 'peran')->first()->id,
                'priority_division2' => Division::where('slug', 'it')->first()->id,
                'division_accepted' => null,
                'stage' => 4
            ],
            [
                'name' => 'Ella Arminta',
                'email' => 'c14210109@john.petra.ac.id',
                'major_id' => Major::where('name', 'SISTEM INFORMASI BISNIS')->first()->id,
                'gender' => 0,
                'religion' => 'Kristen',
                'birthplace' => 'Surabaya',
                'birthdate' => '2003-08-14',
                'address' => 'Jl. Raya Darmo Permai III/1',
                'province' => 'Jawa Timur',
                'city' => 'Surabaya',
                'postal_code' => '60189',
                'line' => 'leonickh',
                'phone' => '081234567890',
                'instagram' => 'leonickh',
                'tiktok' => 'leonickh',
                'gpa' => '3.95',
                'motivation' => 'Saya ingin mengembangkan diri saya',
                'commitment' => 'Saya akan berkomitmen untuk mengikuti kegiatan WGG',
                'strength' => 'Saya memiliki kekuatan untuk mengikuti kegiatan WGG',
                'weakness' => 'Saya memiliki kelemahan untuk mengikuti kegiatan WGG',
                'experience' => 'Saya memiliki pengalaman untuk mengikuti kegiatan WGG',
                'diet' => 'Tidak ada',
                'allergy' => 'Tidak ada',
                'medical_history' => [
                    'other_disease' => '-',
                    'disease_explanation' => '-',
                    'medication_allergy' => '-',
                ],
                'astor' => 0,
                'priority_division1' => Division::where('slug', 'acara')->first()->id,
                'priority_division2' => Division::where('slug', 'konsum')->first()->id,
                'division_accepted' => null,
                'stage' => 4
            ],
        ];
        foreach ($applicants as $applicant) {
            Applicant::create($applicant);
        }
    }
}
