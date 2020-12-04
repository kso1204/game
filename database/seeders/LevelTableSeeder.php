<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $level_1=['level'=>1,'exp'=>25,'hp'=>50];
        $level_2=['level'=>2,'exp'=>50,'hp'=>100];
        $level_3=['level'=>3,'exp'=>200,'hp'=>200];
        $level_4=['level'=>4,'exp'=>600,'hp'=>400];
        $level_5=['level'=>5,'exp'=>1200,'hp'=>800];
        $level_6=['level'=>6,'exp'=>2400,'hp'=>1600];
        $level_7=['level'=>7,'exp'=>6400,'hp'=>3200];
        $level_8=['level'=>8,'exp'=>12800,'hp'=>6400];
        $level_9=['level'=>9,'exp'=>25600,'hp'=>12800];
        $level_10=['level'=>10,'exp'=>51200,'hp'=>25600];

        $level[] = $level_1;
        $level[] = $level_2;
        $level[] = $level_3;
        $level[] = $level_4;
        $level[] = $level_5;
        $level[] = $level_6;
        $level[] = $level_7;
        $level[] = $level_8;
        $level[] = $level_9;
        $level[] = $level_10;

        DB::table('levels')->insert(
            $level
        );

    }
}
