<?php

namespace App\Services;
use App\Models\User;

class UserService
{
    protected $user;
    protected $msg;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function Heal()
    {
        $random_num = rand(10,80);

        if ($random_num>=76) {  

            $request->hp=$this->maxHp;
            $this->msg="Great Heal!! Your Hp is Full";

        } else {
            $this->updateHp= $random_num * $this->difficulty;

            $request->hp += $this->updateHp;

            
            $this->msg="Healing\n Hp + ".$this->updateHp;

            if($request->hp>=$this->maxHp){
                $request->hp=$this->maxHp;
                $this->msg="Your Hp is Full";
            }
        }
        


        $this->userUpdate($request);


        return response()->json([
            'msg' => $this->msg,
            'user' => Auth()->user(),
        ]); 
    }
}


?>