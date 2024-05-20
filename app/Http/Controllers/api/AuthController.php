<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function login()
    {
        
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        if($user) {
            $token = auth()->login($user);
            return $this->responseWithToken($token, $user);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Can not create a new user',
            ], 500);
        }
    }

    public function responseWithToken($token, $user)
    {
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'access_token' => $token,
            'type' => 'bearer',
        ]);
    }
}
