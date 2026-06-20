<?php

namespace App\Listeners;

use App\Events\UserAuthenticated;
use App\Models\UserSession;

class CreateUserSessionListener
{
    public function handle(UserAuthenticated $event): void
    {
        UserSession::create([
            'user_id' => $event->user->id,
            'access_token' => $event->accessToken,
            'refresh_token' => $event->refreshToken,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'expires_at' => now()->addDays(7),
        ]);
    }

}
