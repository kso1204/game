<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    public static function getHp($level){
        return Level::where('level',$level)->get()->pluck('hp');
    }

    public static function getExp($level){
        return Level::where('level',$level)->get()->pluck('exp');
    }

    public static function isLevelUp($exp){
        return Level::where('exp','>',$exp)->get()->pluck('level');
    }
}
