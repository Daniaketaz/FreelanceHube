<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    protected $fillable = [
        'user_id',
        'refresh_token',
        'access_token',
        'ip_address',
        'user_agent',
        'expires_at',
        'is_revoked',
    ];


    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function User(){
        return $this->belongsTo(User::class,'user_id');
    }
}
