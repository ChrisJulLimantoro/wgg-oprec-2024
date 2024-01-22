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
                'name' => 'Sallyne Benedicta J.S.',
                'email' => 'c13220021@john.petra.ac.id',
                'line' => 'sallynebjs',
                'division_id' => Division::where('slug','acara')->first()->id 
            ],
            [ 
                'name' => 'Marcellino Nicholas Chen',
                'email' => 'd11220093@john.petra.ac.id',
                'line' => 'marcelnich03',
                'division_id' => Division::where('slug','acara')->first()->id 
            ],
            [
                'name' => 'Amanda Chandra',
                'email' => 'b11220019@john.petra.ac.id',
                'line' => 'amandachandra4',
                'division_id' => Division::where('slug','acara')->first()->id 
            ],
            [ 
                'name' => 'Michael Winata',
                'email' => 'b11220013@john.petra.ac.id',
                'line' => 'michael_win',
                'division_id' => Division::where('slug','acara')->first()->id 
            ],
            [ 
                'name' => 'Mahersya Christiani Setiadiwiria',
                'email' => 'd11220102@john.petra.ac.id',
                'line' => 'inyong.cha',
                'division_id' => Division::where('slug','acara')->first()->id 
            ],
            [ 
                'name' => 'Winson Pratama Kho',
                'email' => 'b11220007@john.petra.ac.id',
                'line' => 'winson_p.kho',
                'division_id' => Division::where('slug','acara')->first()->id 
            ],
            [ 
                'name' => 'Jenica Tendean',
                'email' => 'f11220022@john.petra.ac.id',
                'line' => 'jenica07',
                'division_id' => Division::where('slug','acara')->first()->id 
            ],
            [ 
                'name' => 'Amelia Wibisono',
                'email' => 'c14220160@john.petra.ac.id',
                'line' => 'ameriya_',
                'division_id' => Division::where('slug','acara')->first()->id 
            ],
            [ 
                'name' => 'Viorysca'
                ,'email' => 'd12220101@john.petra.ac.id',
                'line' => 'vzha.ng',
                'division_id' => Division::where('slug','bph')->first()->id 
            ],
            [ 
                'name' => 'Natasha Adeline',
                'email' => 'd12220016@john.petra.ac.id',
                'line' => 'andreasnatasha',
                'division_id' => Division::where('slug','bph')->first()->id 
            ],
            [ 
                'name' => 'Rafael Allan Surya Putra',
                'email' => 'd12210120@john.petra.ac.id',
                'line' => 'rafaelallando',
                'division_id' => Division::where('slug','bph')->first()->id 
            ],
            [ 
                'name' => 'Vania Angel',
                'email' => 'f11210017@john.petra.ac.id',
                'line' => 'vania_angel27',
                'division_id' => Division::where('slug','bph')->first()->id 
            ],
            [ 
                'name' => 'Lazaro Batigol Lauwono',
                'email' => 'd11210059@john.petra.ac.id',
                'line' => 'lazarolauwono',
                'division_id' => Division::where('slug','bph')->first()->id 
            ],
            [ 
                'name' => 'Michael Genesis Bimasatrya de Fretes',
                'email' => 'd11210512@john.petra.ac.id',
                'line' => 'michael__123',
                'division_id' => Division::where('slug','bph')->first()->id 
            ],
            [ 
                'name' => 'Everson Sugianto',
                'email' => 'd11210185@john.petra.ac.id',
                'line' => 'everson.sugianto',
                'division_id' => Division::where('slug','bph')->first()->id 
            ],
            [ 
                'name' => 'Jennifer Fiolyn',
                'email' => 'd11220037@john.petra.ac.id',
                'line' => 'jenniferfiolyn.',
                'division_id' => Division::where('slug','bph')->first()->id 
            ],
            [ 
                'name' => 'Nathalia Devita Wijaya',
                'email' => 'c14210009@john.petra.ac.id',
                'line' => 'nathaliadev02',
                'division_id' => Division::where('slug','bph')->first()->id 
            ],
            [ 
                'name' => 'Lucky Leonardo Kastan',
                'email' => 'f11220089@john.petra.ac.id',
                'line' => 'luckyleonardo09',
                'division_id' => Division::where('slug','bph')->first()->id 
            ],
            [ 
                'name' => 'Gabriel Angelica Surjanto',
                'email' => 'e12220127@john.petra.ac.id',
                'line' => 'gabriel.angelica',
                'division_id' => Division::where('slug','creative')->first()->id 
            ],
            [ 
                'name' => 'Nathanael Kenneth Suryawan ',
                'email' => 'b11210011@john.petra.ac.id',
                'line' => 'kenneth2004',
                'division_id' => Division::where('slug','creative')->first()->id 
            ],
            [ 
                'name' => 'Audrey Christine Soenarjo',
                'email' => 'd11220293@john.petra.ac.id',
                'line' => 'Audrey05112003',
                'division_id' => Division::where('slug','creative')->first()->id 
            ],
            [ 
                'name' => 'Yeshua Imanuel',
                'email' => 'f11220052@john.petra.ac.id',
                'line' => 'yeshuaii',
                'division_id' => Division::where('slug','creative')->first()->id 
            ],
            [ 
                'name' => 'Gabriella Christiani Widjaja',
                'email' => 'd11220076@john.petra.ac.id',
                'line' => 'gabriella.14',
                'division_id' => Division::where('slug','creative')->first()->id 
            ],
            [ 
                'name' => 'Shevina Stella',
                'email' => 'e12220039@john.petra.ac.id',
                'line' => '081252718181',
                'division_id' => Division::where('slug','creative')->first()->id 
            ],
            [ 
                'name' => 'Matthew Nathanael Wiena',
                'email' => 'e12220066@john.petra.ac.id',
                'line' => 'mattnath',
                'division_id' => Division::where('slug','creative')->first()->id 
            ],
            [ 
                'name' => 'Christopher Julius Limantoro',
                'email' => 'c14210073@john.petra.ac.id',
                'line' => 'chris_julius',
                'division_id' => Division::where('slug','it')->first()->id 
            ],
            [ 
                'name' => 'Elizabeth Celine Liong',
                'email' => 'c14220061@john.petra.ac.id',
                'line' => 'ecl24',
                'division_id' => Division::where('slug','it')->first()->id 
            ],
            [ 
                'name' => 'Nico Samuelson Tjandra',
                'email' => 'c14210017@john.petra.ac.id',
                'line' => 'nicos.t.',
                'division_id' => Division::where('slug','it')->first()->id 
            ],
            [ 
                'name' => 'Christophorus Ivan Sunjaya',
                'email' => 'c14220210@john.petra.ac.id',
                'line' => 'Sun_04',
                'division_id' => Division::where('slug','it')->first()->id 
            ],
            [ 
                'name' => 'Darrell Cornelius Rivaldo',
                'email' => 'c14210025@john.petra.ac.id',
                'line' => 'darrell7103',
                'division_id' => Division::where('slug','it')->first()->id 
            ],
            [ 
                'name' => 'Cathlyn Angeline',
                'email' => 'c14220133@john.petra.ac.id',
                'line' => 'cathlyn___angeline',
                'division_id' => Division::where('slug','kesehatan')->first()->id 
            ],
            [ 
                'name' => 'Sherryl Giselle',
                'email' => 'd12220141@john.petra.ac.id',
                'line' => 'Sherryl_g.p',
                'division_id' => Division::where('slug','kesehatan')->first()->id 
            ],
            [ 
                'name' => 'gerry elnathan tantoso',
                'email' => 'c14220321@john.petra.ac.id',
                'line' => 'gerry1501',
                'division_id' => Division::where('slug','kesehatan')->first()->id 
            ],
            [ 
                'name' => 'Claudia Alveriza',
                'email' => 'd11220002@john.petra.ac.id',
                'line' => 'claudiaalveriza',
                'division_id' => Division::where('slug','kesehatan')->first()->id 
            ],
            [ 
                'name' => 'Stella Halim',
                'email' => 'd11220008@john.petra.ac.id',
                'line' => 'stellahalim21',
                'division_id' => Division::where('slug','kesehatan')->first()->id 
            ],
            [ 
                'name' => 'Clea Alvina',
                'email' => 'f11220064@john.petra.ac.id',
                'line' => 'clea_alvina',
                'division_id' => Division::where('slug','konsum')->first()->id 
            ],
            [ 
                'name' => 'stephanie kezia',
                'email' => 'd11220344@john.petra.ac.id',
                'line' => 'kezia.lo',
                'division_id' => Division::where('slug','konsum')->first()->id 
            ],
            [ 
                'name' => 'Graciella Viony',
                'email' => 'f11220032@john.petra.ac.id',
                'line' => 'graciella7nop',
                'division_id' => Division::where('slug','konsum')->first()->id 
            ],
            [ 
                'name' => 'Ivan Sebastian Hartato',
                'email' => 'd11220255@john.petra.ac.id',
                'line' => 'ivansebastianhartato',
                'division_id' => Division::where('slug','konsum')->first()->id 
            ],
            [ 
                'name' => 'Joenathan Poo',
                'email' => 'd11220187@john.petra.ac.id',
                'line' => 'joenathanpoo',
                'division_id' => Division::where('slug','konsum')->first()->id 
            ],
            [ 
                'name' => 'Josephine Michella Mulyadi',
                'email' => 'd11220055@john.petra.ac.id',
                'line' => 'ttokkidokiie',
                'division_id' => Division::where('slug','konsum')->first()->id 
            ],
            [ 
                'name' => 'Felicia Angela Rumbajan',
                'email' => 'd12220088@john.petra.ac.id',
                'line' => 'feli634',
                'division_id' => Division::where('slug','perkap')->first()->id 
            ],
            [ 
                'name' => 'Michael Liem',
                'email' => 'd11210178@john.petra.ac.id',
                'line' => 'mike.l07',
                'division_id' => Division::where('slug','perkap')->first()->id 
            ],
            [ 
                'name' => 'Marcella Violeta Widjaja',
                'email' => 'd11220126@john.petra.ac.id',
                'line' => 'marcellaa4',
                'division_id' => Division::where('slug','perkap')->first()->id 
            ],
            [ 
                'name' => 'Eliza Paul Yan',
                'email' => 'e12220022@john.petra.ac.id',
                'line' => 'jokmaenae',
                'division_id' => Division::where('slug','perkap')->first()->id 
            ],
            [ 
                'name' => 'Samuel Andrelio',
                'email' => 'c14220109@john.petra.ac.id',
                'line' => 'samuelsam12',
                'division_id' => Division::where('slug','perkap')->first()->id 
            ],
            [ 
                'name' => ' Jeremy Axel Siswanto',
                'email' => 'f11220020@john.petra.ac.id',
                'line' => 'Jeremyaxelll',
                'division_id' => Division::where('slug','perkap')->first()->id 
            ],
            [ 
                'name' => 'Eloise Kardia Tirtowidjojo',
                'email' => 'b12220010@john.petra.ac.id',
                'line' => 'eloisekardia',
                'division_id' => Division::where('slug','regul')->first()->id 
            ],
            [ 
                'name' => 'Emanuel Kristian Aditiyanto',
                'email' => 'f11210005@john.petra.ac.id',
                'line' => 'emanuel_89',
                'division_id' => Division::where('slug','regul')->first()->id 
            ],
            [ 
                'name' => 'Jessyca Priskila Kuncoro',
                'email' => 'f11210009@john.petra.ac.id',
                'line' => 'jeskunn_',
                'division_id' => Division::where('slug','regul')->first()->id 
            ],
            [ 
                'name' => 'Fidelia Visca Budiman',
                'email' => 'e11220017@john.petra.ac.id',
                'line' => 'fidelv',
                'division_id' => Division::where('slug','regul')->first()->id 
            ],
            [ 
                'name' => 'Hugo Christopher Candra',
                'email' => 'e12220110@john.petra.ac.id',
                'line' => 'hugocandra4456',
                'division_id' => Division::where('slug','regul')->first()->id 
            ],
            [ 
                'name' => 'Devon Ewaldo',
                'email' => 'e12220092@john.petra.ac.id',
                'line' => 'devon.ewaldo',
                'division_id' => Division::where('slug','regul')->first()->id 
            ],
            [ 
                'name' => 'Monica Josephine',
                'email' => 'a11220010@john.petra.ac.id',
                'line' => 'monica26_',
                'division_id' => Division::where('slug','sekret')->first()->id 
            ],
            [ 
                'name' => 'Grizel Witartha',
                'email' => 'd12220073@john.petra.ac.id',
                'line' => 'Grizz_el',
                'division_id' => Division::where('slug','sekret')->first()->id 
            ],
            [ 
                'name' => 'Nelson Setiawan Lie',
                'email' => 'c14220247@john.petra.ac.id',
                'line' => 'nelson.lie',
                'division_id' => Division::where('slug','sekret')->first()->id 
            ],
            [ 
                'name' => 'Marvel2412',
                'email' => 'c14220223@john.petra.ac.id',
                'line' => 'marvel2412',
                'division_id' => Division::where('slug','sekret')->first()->id 
            ],
            [ 
                'name' => 'Jocelyn Jane Michaela',
                'email' => 'd12220012@john.petra.ac.id',
                'line' => 'jocelynjane0509',
                'division_id' => Division::where('slug','sekret')->first()->id 
            ],
            [ 
                'name' => 'Alexander Yofilio',
                'email' => 'c14220071@john.petra.ac.id',
                'line' => 'lio2511',
                'division_id' => Division::where('slug','regul')->first()->id 
            ],
        ];
        foreach($admins as $admin){
            Admin::create($admin);
        }
    }
}
