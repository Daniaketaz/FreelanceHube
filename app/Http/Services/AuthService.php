<?php


namespace App\Http\Services;

use App\Events\UserAuthenticated;
use App\Events\UserLoggedIn;
use App\Events\UserLoggedOut;
use App\Events\UserRegistered;
use App\Http\Repositories\UserSessionRepository;
use App\Models\UserSession;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        private UserRepository $userRepository ,
        protected UserSessionRepository $userSessionRepository
        ){}

    public function register(array $data):array{

        $user = $this->userRepository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $accessToken = JWTAuth::fromUser($user);
        $refreshToken = Str::random(80);

        event(new UserAuthenticated(
            $user,
            $accessToken,
            $refreshToken
        ));

        return [
            'user' => $user,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ];
    }

    public function login(array $data):array {

        if(!auth('api')->attempt($data)){
            throw new \Exception('Invalid credentials');
        }
        $user = auth('api')->user();

        $accessToken = JWTAuth::fromUser($user);

        $refreshToken = Str::random(80);

        event(new UserAuthenticated(
            $user,
            $accessToken,
            $refreshToken
        ));

        return [
            'user' => $user,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ];
    }

    public function logout(): void
    {
        $user = auth('api')->user();

        $token = (string) JWTAuth::getToken();

        event(new UserLoggedOut(
            $user,
            $token
        ));

        auth('api')->logout();
    }

    public function refresh(
        string $refreshToken
        ): array {
        $session = $this->userSessionRepository
            ->findValidSession(
                $refreshToken
            );

        if (! $session) {
            throw ValidationException::withMessages([
                'refresh_token' => [
                    'Invalid refresh token'
                ]
            ]);
        }

        if ($session->expires_at->isPast()) {
            throw ValidationException::withMessages([
                'refresh_token' => [
                    'Refresh token expired'
                ]
            ]);
        }
        $user = $this->userRepository->findOrFail($session->user_id);

        $newAccessToken = JWTAuth::fromUser(
            $user
        );

        /**
         * Refresh Token Rotation
         */
        $newRefreshToken = Str::random(80);

        $this->userSessionRepository
            ->updateTokens(
                $session,
                $newRefreshToken
            );

        return [
            'access_token' => $newAccessToken,
            'refresh_token' => $newRefreshToken,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ];
    }



}
