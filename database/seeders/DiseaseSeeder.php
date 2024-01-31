<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diseases = [
            'Riwayat keluarga sakit jantung',
            'Mengunjungi cardiologist (spesialis jantung)',
            'Stroke',
            'Autoimun',
            'Masalah kulit (psoriasis, eczema/dermatitis, herpes, eksim)',
            'Riwayat epilepsy (kejang-kejang)',
            'Riwayat kehilangan kesadaran, pingsan (sering / berulang)',
            'Tumor / kista / benjolan abnormal / kanker',
            'Sakit di dada (chest pain), dada terasa ditekan (chest pressure) atau palpitations (berdebar-debar)',
            'Masalah jantung (bising jantung, kelainan irama, peredaran darah)',
            'Asma (kesulitan bernafas)',
            'Sakit paru-paru (TBC, paru-paru basah, bronkitis)',
            'Diabetes (masalah gula darah)',
            'Masalah pencernaan, lambung, liver (hepatitis) / kandung empedu',
            'Penyakit usus (Crohns, Ulcerative Colitis, Reflux, dan sebagainya)',
            'Kelainan kelenjar (hipotiroid, hipertiroid, pankreatitis, dan sebagainya)',
            'Vertigo atau claustrophobia (phobia ruang sempit & tertutup)',
            'Gangguan pada mata (katarak, buta warna, glaukoma, dan sebagainya)',
            'Gangguan pendengaran (infeksi telinga, peradangan, tuli, dan sebagainya)',
            'Gangguan sendi (dislokasi, terkilir, rematik)',
            'Gangguan / kelainan pada tulang (pernah terjadi retak dalam 5 tahun terakhir / sedang memakai pin besi, pelat, kawat, dan sebagainya)',
            'Gangguan pada hidung (rhinitis, sinusitis)',
            'Kelainan/sakit punggung, leher (parah/berulang)',
            'Kelainan darah (Hemofilia, Anemia, Leukemia, Hipertensi)',
            'Gangguan mental atau kejiwaan (Bipolar disorder, Schizophrenia, Psychosis, Depresi)',
            'ADD (Attention Deficit Disorder = tidak bisa fokus)',
        ];

        foreach ($diseases as $disease) {
            \App\Models\Disease::create([
                'name' => $disease,
            ]);
        }
    }
}
