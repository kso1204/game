<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use App\Models\Record;
use App\Models\Difficulty;
use Illuminate\Http\Request;

class AttackController extends Controller
{
    //
    private $maxHp;
    private $user;
    private $updateHp;
    private $updateExp;
    private $difficulty;
    private $cnt;
    private $msg;

    public function __construct(Request $request){
        $this->cnt = $request->cnt + 1;
        $this->maxHp = Level::getHp($request->level);
        $this->difficulty = Difficulty::getDifficulty($request->level);
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

    public function actionUpdate(Request $request) {

        if ($request->hp <= 0) {

            $request->level -= 1;

            if ($request->level<=1){
                
                $request->level = 1;
                $request->hp = Level::getHp(1);
                $request->exp = 0;

            } else {
                $request->hp = Level::getHp($request->level);
                $request->exp = Level::getExp($request->level);
            }


            $request->die += 1;

            $this->msg = "You Die";
            
        } else {
            $levelUp = Level::isLevelUp($request->exp);
            
            if ($levelUp > $request->level) {
                $request->hp = Level::getHp($levelUp);
                $request->level = $levelUp;
                $this->msg = "Level Up!!";
            }
        }

    }

    public function userUpdate(Request $request){
        User::where('id', $request->id)->update(
            [
                'level'=> $request->level,
                'exp'=> $request->exp,
                'hp'=> $request->hp,
                'cnt' => $this->cnt,
                'die' => $request->die,
            ]
        );

        if($this->cnt==100) {
            $this->save($request);
        }
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

        $this->msg="Reset!!";

        return response()->json([
            'msg' => $this->msg,
            'user' => Auth()->user(),
        ]);

    }

    public function save(Request $request)
    {
        
        if($request->exp>$request->high_record){
            $request->high_record = $request->exp;
        }

        $this->msg="End Game!! Your score is recorded";
        
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

        //dd($this->user);

        $this->updateHp= rand(5,30) * $this->difficulty;

        $request->hp += $this->updateHp;

        
        $this->msg="Healing\n Hp + ".$this->updateHp;

        if($request->hp>=$this->maxHp){
            $request->hp=$this->maxHp;
            $this->msg="Your Hp is Full";
        }

        $this->userUpdate($request);
        

        return response()->json([
            'msg' => $this->msg,
            'user' => Auth()->user(),
        ]); 

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

        //단계별로 시행한다면?
        
        //cnt Update
        
        //hp update

        //exp update

        //level update

        //msg update

        //return 위에 있는 부분들을 controller에 다 넣는다면 사실상 중복되는 함수를 또 가지게 되는 것 아닌가..?

        //hp를 처리할 때 case가 두 가지가 있는데

        //hp회복, hp감소
        

        //hp회복일 때 hp가 맥스인지, hp감소일 때 죽음

        //max면 msg변경

        //죽으면 레벨 다운 + exp가져옴?
        //근데 이러면 그냥 죽었을 때 Level 테이블에서 가져오는 게 낫겠네
        //경험치 손실을 10%이런게 아니라 렙따 상태로 만들거니까
        //렙따는 어쩔수없이 if else 써야할듯? 1보다 큰지 아닌지
        //cnt는 그냥 construct단에서 미리 올려버리고

        //이정도면 그래도 괜찮은데 가장 문제 or 고민인건 역시
        //hpUpdate, expUpdate, levelUpdate를 어떻게 처리할 것인지?


        //if(hp += hpupdate()>=max){
             //process 이게 근데 맞나? ㅋㅋ 그냥 소스 좀 줄여본거 같은데
        //}
        



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
        
        $this->updateHp = rand(5,15) * $this->difficulty;
        $this->updateExp = rand(2,5) * $this->difficulty;

        $this->msg="Attack Success!!\n Exp +".$this->updateExp."\n Hp - ".$this->updateHp;

        $request->hp -= $this->updateHp;
        $request->exp += $this->updateExp;

        
        $this->actionUpdate($request);
        $this->userUpdate($request);
        

        return response()->json([
            'msg' => $this->msg,
            'user' => Auth()->user(),
        ]); 


    }
    public function skillOne(Request $request)
    {   
        $this->updateHp = rand(10,30) * $this->difficulty;
        $this->updateExp = rand(5,15) * $this->difficulty;

        $this->msg="Skill Success!!\n Exp +".$this->updateExp."\n Hp - ".$this->updateHp;

        $request->hp -= $this->updateHp;
        $request->exp += $this->updateExp;

        
        $this->actionUpdate($request);
        $this->userUpdate($request);
        

        return response()->json([
            'msg' => $this->msg,
            'user' => Auth()->user(),
        ]); 

    }
    public function skillTwo(Request $request)
    {   
        $this->updateHp = rand(20,60) * $this->difficulty;
        $this->updateExp = rand(15,30) * $this->difficulty;

        $this->msg="Skill Success!!\n Exp +".$this->updateExp."\n Hp - ".$this->updateHp;

        $request->hp -= $this->updateHp;
        $request->exp += $this->updateExp;

        
        $this->actionUpdate($request);
        $this->userUpdate($request);
        

        return response()->json([
            'msg' => $this->msg,
            'user' => Auth()->user(),
        ]); 

    }

    public function skillThree(Request $request)
    {   
        $this->updateHp = rand(40,120) * $this->difficulty;
        $this->updateExp = rand(30,60) * $this->difficulty;

        $this->msg="Skill Success!!\n Exp +".$this->updateExp."\n Hp - ".$this->updateHp;

        $request->hp -= $this->updateHp;
        $request->exp += $this->updateExp;

        
        $this->actionUpdate($request);
        $this->userUpdate($request);
        

        return response()->json([
            'msg' => $this->msg,
            'user' => Auth()->user(),
        ]); 

    }

    public function skillFour(Request $request)
    {   
        
        $this->updateHp = rand(80,240) * $this->difficulty;
        $this->updateExp = rand(60,120) * $this->difficulty;

        $this->msg="Skill Success!!\n Exp +".$this->updateExp."\n Hp - ".$this->updateHp;

        $request->hp -= $this->updateHp;
        $request->exp += $this->updateExp;

        
        $this->actionUpdate($request);
        $this->userUpdate($request);
        

        return response()->json([
            'msg' => $this->msg,
            'user' => Auth()->user(),
        ]); 
        
        /* 
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
 */
    }


    

        
}
