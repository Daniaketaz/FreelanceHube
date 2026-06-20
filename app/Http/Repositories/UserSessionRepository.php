<?php
namespace App\Http\Repositories;
use App\Models\User;
use App\Models\UserSession;

class UserSessionRepository {


    public function __construct(protected User $model)
    {}

    public function findValidSession(string $refreshToken): ?UserSession {
        return UserSession::where(
            'refresh_token',
            $refreshToken
        )
            ->where(
                'is_revoked',
                false
            )
            ->first();
    }

    public function updateTokens(
        UserSession $session,
        string $refreshToken ): void {
        $session->update([
            'refresh_token' => $refreshToken,
        ]);
    }
}
