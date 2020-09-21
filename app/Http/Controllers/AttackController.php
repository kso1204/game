<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AttackController extends Controller
{
    //
    

    public function attack(Request $request)
    {   
        $request->exp += 5;
        $request->hp -= 3;

        

        return User::where('id', $request->id)->update(
            ['exp'=> $request->exp,
             'hp'=> $request->hp,
            ]
        );

    }
        
}
