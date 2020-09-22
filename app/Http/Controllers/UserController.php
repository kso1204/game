<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function getUser(Request $request)
    {
        return User::orderBy('exp','desc')->take(10)->get();
    }
}
