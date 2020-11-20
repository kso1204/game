# 미니게임

http://3.34.193.68/

힐, 공격, 스킬4개를 버튼으로 표현하고 해당 스킬을 눌러서 획득한 EXP가 점수..

그 점수를 기록하여 랭킹을 보여주는 시스템입니다.

AWS에 구현했으나, 현재 Key를 분실하여.. 찾으면 시스템 점검을 좀 해야할듯? ㅠㅠ

이전에 개발 했을 때 컨트롤러에 모든 기능을 넣었더니 너무 뚱뚱하다..

이것저것 찾아봤더니 프로그램 단점이 너무 많이 보임!

핵심 요구사항

1. 백 번 하면 레코드 기록 + 초기화

2. 한 번 할 때마다 카운트 + 해당 내용 업데이트

3. 레벨업하면 HP 회복, 레벨 다운하면 EXP 초기화 & HP 회복


개선하고 싶은 사항

1. 우선 레벨 업, 레벨 다운 했을 때 Level 모델에서 데이터를 가져온다면? 

 - 기존에는 컨트롤러에서 function을 만들어서 가져왔다.

2. 레벨과 비례하는 게임 난이도 부분이 있는데.. 컨트롤러 내에서 직접 처리 했다.
이 부분을 데이터베이스로 선언하는 게 좋을지.. 아니면 switch문으로 작업하는 게 좋을지 고민이다.

- Level<3 보다 작으면 배수 1 Level<5보다 작으면 배수2 ... 이렇게 구현하고 싶은데 뭐가 좋을까?

```
$cnt=1;
if($request->level>3){
    $cnt=2;
}else if($request->level>6){
    $cnt=3;
}else if($request->level>8){
    $cnt=4;
}
```

Difficulty 테이블을 만들어서 각 레벨에 대한 difficulty값을 넣었다..
level_id가 1일때 difficulty도 1이게..? 이렇게 하는게 아닌 것 같은데

3. 각 행동(Action)에 대해서 어떻게 처리하는 게 좋을지? 현재는 HP를 회복하는 경우 

```
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

```

컨트롤러에서 힐을 했을 경우 랜덤 + cnt.. hp가 꽉차면 더이상 힐 못하고
힐한 내용을 user에서 다시 업데이트 이런 업데이트 같은 부분도 좀 감이 안온다.

hpPerLevel이 부분은 Level에서 
```
public static function getHp($level){
    return Level::where('level',$level)->get()->pluck('hp');
}
```
이렇게 바꿔서 사용하려고 하는데 이정도면 그래도 좀 괜찮은 것 같다.

4. 요청에 대한 처리와 기존 사용자 정보에 대해서 어떻게 나누어야 할지 잘 모르겠다.
원래 기존 소스는 $request에 user data를 다 넘겨서 왔기 때문에, $request자체를 사용했는데
이 상태에서 사용하는 게 맞는건지? 아니면 user를 새로 가져오는 게 더 좋은건지..?
user를 새로 가져온다면 request가 의미가 있는건가?.. 이런 궁금증이 생긴다

```
private $hp;
private $user;

public function __construct(Request $request){
    $this->hp = Level::getHp($request->level);
    $this->user = Auth()->user();
}
```

새로운 내용을 배웠지만.. 기존 내용에 변화를 주는 건 너무 어렵다
