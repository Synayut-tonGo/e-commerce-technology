<?php

namespace App\Http\Controllers\Auth;

use App\actions\auth\LoginUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class UserLogin extends Controller
{
    public function login(LoginRequest $request , LoginUserAction $userLogin){
        $credentail = $request->validated();
        return $userLogin->login($credentail);
       
    }
    
}
