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

        //이걸 유저에서 처리한다고 하면..?
        //유저에서 heal인지 attack인지 이걸 다 같이 처리한다고 하면 결국 if문이 필요하다
        //그렇지 않기 위해서는 펑션을 나누는 건데.. 이게 좋은건가? if문이 필요한게 좋은건가
        //Level당 단위가 필요하다
        //회복을 해
        //기존 레벨의 HP보다 회복하는 양이 많으면 MAX HP를 보여줘야함 (초과 X)
        //기존 레벨의 HP랑 회복한 HP 비교하는 기능이 필요
        //회복량 조절하는 변수가 있음
        //이 변수를.. DB에서 가져올지 construct에서 직접 적는게 나을지 모르겠음..ㅠㅠ 여기에 쓰는건 아닌듯;
        //HP를 업데이트하면 user의 내용을 업데이트하고 이 내용을 다시 request로 반환하는 기이한 행동을 함
        //왜그럴까?
        //어떤 이벤트가 나왔을 때 해야할 일은
        //카운트 + 1 hp 변동, Exp 변동, Level 변동, Msg 변동이다
        //어떤 컨트롤러가 나와도 저 액션을 취하고 그 액션에서 다른 액션으로 쪼개진다고 하면
        //기본적으로 저 액션을 컨트롤 하는 function이나.. 모델에서 컨트롤하면 좋을 것 같은데??
        //User모델로 보내면 어떨까?
        //User::action(힐, type) or User::heal(이건 좀 이상하지 않나 근데?;)
        //
        


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
