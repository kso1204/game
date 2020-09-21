<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function getUser(Request $request, $id)
    {
        return User::where('id',$id)->get();
    }
}
