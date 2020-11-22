<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RecordResource;

class RecordController extends Controller
{
    //
    public function getRecord()
    {
        $record=Record::find(1);
        
        return new RecordResource($record);


        
        //$records=Record::orderBy('score','desc')->take(10)->get();
        //return $records->user;
        
        //dd(User::whereIn('user_id', $records->pluck('user_id'))->get());
        /* 
        return DB::table('records')
        ->leftJoin('users','users.id','=','records.user_id')
        ->orderBy('score','desc')->take(10)->get(); */
    }
}
