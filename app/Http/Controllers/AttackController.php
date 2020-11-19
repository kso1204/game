<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use App\Models\Record;
use Illuminate\Http\Request;

class AttackController extends Controller
{
    //
    private $hp;
    private $user;

    public function __construct(Request $request){
        $this->hp = Level::getHp($request->level);
        $this->user = Auth()->user();
    }
    
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

    public function save(Request $request)
    {
        
        $user = $this->userGet($request);

        if($request->exp>$request->high_record){
            $request->high_record = $request->exp;
        }
        
        Record::create(
            [
                'user_id'=>$request->id,
                'score'=>$request->exp,
            ]
        );

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
    }

    public function heal(Request $request)
    {   
        
       // dd($this->hp);
        dd($this->user);

/* 
        $cnt=1;
        if($request->level>3){
            $cnt=2;
        }else if($request->level>6){
            $cnt=3;
        }else if($request->level>8){
            $cnt=4;
        }

        $minusHp = rand(5,30)*$cnt;

        $request->hp += $minusHp;

        $maxHp=$this->hpPerLevel($request->level)[0];

        
        $msg="Healing\n Hp + ".$minusHp;

        if($request->hp>=$maxHp)
        {
            $request->hp=$maxHp;
            $msg="Your Hp is Full";
        }

        
        $this->userUpdate($request);

        $user = $this->userGet($request);

        
        if($request->cnt>=99){
            $this->save($request);
            $user = $this->userGet($request);
            $msg="End Game!! Your score is recorded";
        }
        
        return response()->json([
            'msg' => $msg,
            'user' => $user,
        ]); */

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

        $plusExp = rand(1,5)*$cnt;
        $minusHp = rand(5,15)*$cnt;
        $request->exp += $plusExp;
        $request->hp -= $minusHp;

        $msg="Attack Success!!\n Exp +".$plusExp."\n Hp - ".$minusHp;
        
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

        
        if($request->cnt>=99){
            $this->save($request);
            $user = $this->userGet($request);
            $msg="End Game!! Your score is recorded";
        }
        
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

        
        $plusExp = rand(3,10)*$cnt;
        $minusHp = rand(10,30)*$cnt;
        $request->exp += $plusExp;
        $request->hp -= $minusHp;

        $msg="Skill Success!!\n Exp +".$plusExp."\n Hp - ".$minusHp;
        
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
        
        
        if($request->cnt>=99){
            $this->save($request);
            $user = $this->userGet($request);
            $msg="End Game!! Your score is recorded";
        }

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

        
        
        $plusExp = rand(5,20)*$cnt;
        $minusHp = rand(20,50)*$cnt;
        $request->exp += $plusExp;
        $request->hp -= $minusHp;
        

        

        $msg="Skill Success!!\n Exp +".$plusExp."\n Hp - ".$minusHp;
        
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
        
        
        if($request->cnt>=99){
            $this->save($request);
            $user = $this->userGet($request);
            $msg="End Game!! Your score is recorded";
        }

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


        
        
        $plusExp = rand(10,40)*$cnt;
        $minusHp = rand(35,80)*$cnt;
        $request->exp += $plusExp;
        $request->hp -= $minusHp;
        

        

        $msg="Skill Success!!\n Exp +".$plusExp."\n Hp - ".$minusHp;

        
        

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
        
        
        if($request->cnt>=99){
            $this->save($request);
            $user = $this->userGet($request);
            $msg="End Game!! Your score is recorded";
        }

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

        
        
        $plusExp = rand(20,100)*$cnt;
        $minusHp = rand(60,150)*$cnt;
        $request->exp += $plusExp;
        $request->hp -= $minusHp;
        

        

        $msg="Skill Success!!\n Exp +".$plusExp."\n Hp - ".$minusHp;

        
        

        
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
        
        
        if($request->cnt>=99){
            $this->save($request);
            $user = $this->userGet($request);
            $msg="End Game!! Your score is recorded";
        }
        
        return response()->json([
            'msg' => $msg,
            'user' => $user,
        ]);

    }


    

        
}
