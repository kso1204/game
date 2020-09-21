<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/* 
interface Component
{
    public function operation();
} */


class BasicAttack extends Model 
{
    use HasFactory;

    public function operation()
    {
        return "Attack";
    }
}
