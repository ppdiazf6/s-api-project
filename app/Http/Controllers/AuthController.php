<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

use Tymon\JWTAuth\Facades\JWTAuth;

use App\Models\User;

class AuthController extends Controller
{
    //
	public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        return response()->json([
			'message' => 'Usuario creado correctamente',
			'user' => $user
		], 201);
        
    }
	//	
	public function login(LoginRequest $request)
    {
        $credentials = $request->only('email','password');

        if(!$token = auth('api')->attempt($credentials)){
            return response()->json([
                'message'=>'Unauthorized'
            ],401);
        }

        return response()->json([
            'token'=>$token,
			'type' => 'bearer'
        ],200);
    }
}
