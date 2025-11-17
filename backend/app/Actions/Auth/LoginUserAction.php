<?php

namespace App\actions\auth;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class LoginUserAction
{
    /**
     * Create a new class instance.
     */
    public function login(array $credentail)
    {
        //
        try{
            if(!$token = JWTAuth::attempt($credentail)){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 401);
            }
        }catch(JWTException $e){
            return response()->json([
                'status'  => 'error',
                'message' => 'Could not create token.',
            ], 500);            
        }
        /** @var \App\Models\Users $user */
        $user = Auth::user();

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
            'message'     => 'Login successful.',
            'user'        => $user,
            'token'       => $token,
            'token_type'  => 'bearer',
            'userRole' => $userRole,
        ]);
        
    }
}
