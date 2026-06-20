<?php

namespace App\Listeners;

use App\Events\UserLoggedOut;
use App\Models\UserSession;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RevokeSessionListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLoggedOut $event): void
    {
        UserSession::where(
            'access_token',
            $event->token
        )->update([
            'is_revoked' => true,
        ]);
    }
}
