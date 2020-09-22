<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{
    //
    public function getRecord()
    {
        
        return DB::table('records')
        ->leftJoin('users','users.id','=','records.user_id')
        ->orderBy('score','desc')->take(10)->get();
    }
}
