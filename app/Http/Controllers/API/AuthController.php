<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('accessToken')->accessToken;

            return response()->json([
                'status'        => 'success',
                'message'       => 'User login successfully',
                'accessToken'   => $token,
                'data'          => $user
            ]);
        }
        return $this->apiSuccessResponse('Wrong Credentials', '', 401);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->all());
        return $this->apiSuccessResponse('User registration successfull', $user);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->token()->revoke();
        return $this->apiSuccessResponse('User successfully logout');
    }

    public function authUser(): JsonResponse
    {
        $user = Auth::user();
        if(!$user){
            return $this->apiErrorResponse('Unauthorized');
        }
        
        return $this->apiSuccessResponse('User information', $user);
    }
}
