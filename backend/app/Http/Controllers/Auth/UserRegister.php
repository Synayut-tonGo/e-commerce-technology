<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth ;

class UserRegister extends Controller
{

    public function register(RegisterRequest $request, RegisterUserAction $userRegister)
    {
        // data validated already by RegisterRequest
        $data = $request->validated();

        // create user via Action class
        $user = $userRegister->handle($data);

        // generate JWT token
        $token = JWTAuth::fromUser($user);

        // determine role & destination
        $role = $user->roles()->pluck('slug')->first();

        if ($role === 'super_admin') {
            $userRole = 'super_dashboard';
        } elseif ($role === 'admin') {
            $userRole = 'admin_dashboard';
        } elseif ($role === 'cashier') {
            $userRole = 'pos';
        } else {
            $userRole = 'web';
        }

        return response()->json([
            'status'      => 'success',
            'message'     => 'Registration successful.',
            'user'        => $user,
            'token'       => $token,
            'token_type'  => 'bearer',
            'userRole' => $userRole
        ], 201);
    }
}
