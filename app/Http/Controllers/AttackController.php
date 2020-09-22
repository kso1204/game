<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use Illuminate\Http\Request;

class AttackController extends Controller
{
    //
    
    public function hpPerLevel($level){
        return Level::where('level',$level)->get()->pluck('hp');
    }   

    public function levelPerExp($exp){
        return Level::where('exp','>',$exp)->get()->pluck('level');
    }
    public function expPerLevel($level){
        return Level::where('level',$level)->get()->pluck('exp');
    }
    public function userUpdate(Request $request){
        User::where('id', $request->id)->update(
            [
                'level'=> $request->level,
                'exp'=> $request->exp,
                'hp'=> $request->hp,
                'cnt' => $request->cnt + 1,
                'die' => $request->die,
            ]
        );
    }   
    public function userGet(Request $request){
        return User::where('id',$request->id)->get();
    }   
    public function reset(Request $request)
    {   

        User::where('id', $request->id)->update(
            [
                'level'=> 1,
                'exp'=> 0,
                'hp'=> 50,
                'cnt' => 0,
                'die' => 0,
                'reset' => $request->reset+1,
            ]
        );

        $user = $this->userGet($request);
        $msg="Reset!!";

        return response()->json([
            'msg' => $msg,
            'user' => $user,
        ]);

    }
    public function heal(Request $request)
    {   

        $request->hp += rand(5,15);

        $maxHp=$this->hpPerLevel($request->level)[0];

        $msg="Healing";

        if($request->hp>=$maxHp)
        {
            $request->hp=$maxHp;
            $msg="Your Hp is Full";
        }

        
        $this->userUpdate($request);

        $user = $this->userGet($request);
        
        return response()->json([
            'msg' => $msg,
            'user' => $user,
        ]);

    }
    public function attack(Request $request)
    {   
        $cnt=1;

        if($request->level>3){
            $cnt=2;
        }else if($request->level>6){
            $cnt=3;
        }else if($request->level>8){
            $cnt=4;
        }

        $request->exp += rand(1,5)*$cnt;
        $request->hp -= rand(5,15)*$cnt;

        $msg="Attack Success!!";
        
        if($request->hp<=0){
            if($request->level>1){
                $request->level=$request->level-1;
                $request->hp=$this->hpPerLevel($request->level)[0];
            }else{
                $request->hp=$this->hpPerLevel($request->level)[0];
            }
            $request->exp=$this->expPerLevel($request->level-1)[0];
            $request->die += 1;
            $msg="You Die";
        }else{
            $levelUp=$this->levelPerExp($request->exp)[0];
            if($levelUp>$request->level){
                $request->hp=$this->hpPerLevel($levelUp)[0];
                $request->level=$levelUp;
                $msg="level UP!!";
            }
        }

       

        $this->userUpdate($request);
        $user = $this->userGet($request);
        
        return response()->json([
            'msg' => $msg,
            'user' => $user,
        ]);

    }
    public function skillOne(Request $request)
    {   
        $cnt=1;

        if($request->level>3){
            $cnt=2;
        }else if($request->level>6){
            $cnt=3;
        }else if($request->level>8){
            $cnt=4;
        }

        $request->exp += rand(3,10)*$cnt;
        $request->hp -= rand(10,30)*$cnt;
        

        $msg="Skill Success!!";
        
        if($request->hp<=0){
            if($request->level>1){
                $request->level=$request->level-1;
                $request->hp=$this->hpPerLevel($request->level)[0];
            }else{
                $request->hp=$this->hpPerLevel($request->level)[0];
            }
            $request->exp=$this->expPerLevel($request->level-1)[0];
            $request->die += 1;
            $msg="You Die";
        }else{
            $levelUp=$this->levelPerExp($request->exp)[0];
            if($levelUp>$request->level){
                $request->hp=$this->hpPerLevel($levelUp)[0];
                $request->level=$levelUp;
                $msg="level UP!!";
            }
        }

        $this->userUpdate($request);

        $user = $this->userGet($request);
        
        return response()->json([
            'msg' => $msg,
            'user' => $user,
        ]);

    }
    public function skillTwo(Request $request)
    {   
        $cnt=1;

        if($request->level>3){
            $cnt=2;
        }else if($request->level>6){
            $cnt=3;
        }else if($request->level>8){
            $cnt=4;
        }

        $request->exp += rand(5,20)*$cnt;
        $request->hp -= rand(20,50)*$cnt;
        

        $msg="Skill Success!!";
        
        if($request->hp<=0){
            if($request->level>1){
                $request->level=$request->level-1;
                $request->hp=$this->hpPerLevel($request->level)[0];
            }else{
                $request->hp=$this->hpPerLevel($request->level)[0];
            }
            $request->exp=$this->expPerLevel($request->level-1)[0];
            $request->die += 1;
            $msg="You Die";
        }else{
            $levelUp=$this->levelPerExp($request->exp)[0];
            if($levelUp>$request->level){
                $request->hp=$this->hpPerLevel($levelUp)[0];
                $request->level=$levelUp;
                $msg="level UP!!";
            }
        }

        $this->userUpdate($request);

        $user = $this->userGet($request);
        
        return response()->json([
            'msg' => $msg,
            'user' => $user,
        ]);

    }

    public function skillThree(Request $request)
    {   
        $cnt=1;

        if($request->level>3){
            $cnt=2;
        }else if($request->level>6){
            $cnt=3;
        }else if($request->level>8){
            $cnt=4;
        }

        $request->exp += rand(10,40)*$cnt;
        $request->hp -= rand(35,80)*$cnt;
        
        

        $msg="Skill Success!!";
        
        if($request->hp<=0){
            if($request->level>1){
                $request->level=$request->level-1;
                $request->hp=$this->hpPerLevel($request->level)[0];
            }else{
                $request->hp=$this->hpPerLevel($request->level)[0];
            }
            $request->exp=$this->expPerLevel($request->level-1)[0];
            $request->die += 1;
            $msg="You Die kk";
        }else{
            $levelUp=$this->levelPerExp($request->exp)[0];
            if($levelUp>$request->level){
                $request->hp=$this->hpPerLevel($levelUp)[0];
                $request->level=$levelUp;
                $msg="level UP!!";
            }
        }

        $this->userUpdate($request);

        $user = $this->userGet($request);
        
        return response()->json([
            'msg' => $msg,
            'user' => $user,
        ]);

    }

    public function skillFour(Request $request)
    {   
        $cnt=1;

        if($request->level>3){
            $cnt=2;
        }else if($request->level>6){
            $cnt=3;
        }else if($request->level>8){
            $cnt=4;
        }

        $request->exp += rand(20,100)*$cnt;
        $request->hp -= rand(60,150)*$cnt;
        

        $msg="Skill Success!!";
        
        if($request->hp<=0){
            if($request->level>1){
                $request->level=$request->level-1;
                $request->hp=$this->hpPerLevel($request->level)[0];
            }else{
                $request->hp=$this->hpPerLevel($request->level)[0];
            }
            $request->exp=$this->expPerLevel($request->level-1)[0];
            $request->die += 1;
            $msg="You Die kkk";
        }else{
            $levelUp=$this->levelPerExp($request->exp)[0];
            if($levelUp>$request->level){
                $request->hp=$this->hpPerLevel($levelUp)[0];
                $request->level=$levelUp;
                $msg="level UP!!";
            }
        }

        $this->userUpdate($request);

        $user = $this->userGet($request);
        
        return response()->json([
            'msg' => $msg,
            'user' => $user,
        ]);

    }


    

        
}
