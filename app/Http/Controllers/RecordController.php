<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RecordCollection;

class RecordController extends Controller
{
    //
    private $key = "secret";
    private $redis;

    public function getRecord()
    {
        $this->redis = new \Redis();
        $this->redis->connect(config('database.redis.default.host'), config('database.redis.default.port'));
        $this->redis->auth(['secret']);

        $range = $this->redis->zRange($this->key, 0, 10, true);

        $record=Record::orderBy('score','desc')->take(10)->get();
        
        
        return new RecordCollection($record);


        
        //$records=Record::orderBy('score','desc')->take(10)->get();
        //return $records->user;
        
        //dd(User::whereIn('user_id', $records->pluck('user_id'))->get());
        /* 
        return DB::table('records')
        ->leftJoin('users','users.id','=','records.user_id')
        ->orderBy('score','desc')->take(10)->get(); */
    }

    public function destroy(){

        return Record::where('id',request()->record_id)->delete();
        
    }
}
