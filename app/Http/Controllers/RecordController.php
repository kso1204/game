<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{
    //
    public function getRecord()
    {
        $user = User::class;

        return $user->records;
        //return DB::table('records')->with('users')->orderBy('score','desc')->take(10)->get();
    }
}
