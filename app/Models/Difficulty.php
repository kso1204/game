<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Difficulty extends Model
{
    use HasFactory;

    public static function getDifficulty($level) {
        return Difficulty::where('level_id',$level)->value('difficulty');
    }
}
