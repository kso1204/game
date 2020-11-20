<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DifficultyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $difficulty_1=['level_id'=>1,'difficulty'=>1];
        $difficulty_2=['level_id'=>2,'difficulty'=>1];
        $difficulty_3=['level_id'=>3,'difficulty'=>2];
        $difficulty_4=['level_id'=>4,'difficulty'=>2];
        $difficulty_5=['level_id'=>5,'difficulty'=>2];
        $difficulty_6=['level_id'=>6,'difficulty'=>3];
        $difficulty_7=['level_id'=>7,'difficulty'=>3];
        $difficulty_8=['level_id'=>8,'difficulty'=>3];
        $difficulty_9=['level_id'=>9,'difficulty'=>4];
        $difficulty_10=['level_id'=>10,'difficulty'=>4];

        $difficulty[] = $difficulty_1;
        $difficulty[] = $difficulty_2;
        $difficulty[] = $difficulty_3;
        $difficulty[] = $difficulty_4;
        $difficulty[] = $difficulty_5;
        $difficulty[] = $difficulty_6;
        $difficulty[] = $difficulty_7;
        $difficulty[] = $difficulty_8;
        $difficulty[] = $difficulty_9;
        $difficulty[] = $difficulty_10;

        DB::table('difficulties')->insert(
            $difficulty,
        );
    }
}
