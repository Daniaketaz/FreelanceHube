<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshTokenRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\AuthService;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => [
                'user' => new UserResource($result['user']),
                'access_token' => $result['access_token'],
                'refresh_token' => $result['refresh_token'],
                'token_type'=>$result['token_type'],
                'expires_in'=>$result['expires_in'],
            ]
        ], 201);
    }

    public function login(LoginRequest $request){
        $result =$this->authService->login($request->validated());
        return response()->json([
            'success' => true,
            'data' => [
                'user' => new UserResource($result['user']),
                'access_token' => $result['access_token'],
                'refresh_token' => $result['refresh_token'],
                'token_type' => $result['token_type'],
                'expires_in' => $result['expires_in'],
            ]
        ]);
    }
    public function logout(){
        $this->authService->logout();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
    public function refresh(
        RefreshTokenRequest $request
    )
    {
        $request->validateRefreshRequest();

        $result = $this->authService
            ->refresh(
                $request->refresh_token
            );

        return response()->json([
            'message' => 'Token refreshed successfully',
            'data' => $result
        ]);
    }




}
