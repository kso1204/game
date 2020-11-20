<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    public static function getHp($level){
        return Level::where('level',$level)->value('hp');
    }

    public static function getExp($level){
        return Level::where('level',$level)->value('exp');
    }

    public static function isLevelUp($exp){
        return Level::where('exp','>',$exp)->value('level');
    }
}
