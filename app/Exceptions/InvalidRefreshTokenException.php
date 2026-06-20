<?php

namespace App\Exceptions;

use Exception;

class InvalidRefreshTokenException extends ApiException
{
    protected int $statusCode = 401;
    protected string $errorCode = 'INVALID_REFRESH_TOKEN';
    public function __construct()
    {
        parent::__construct(
            'Invalid refresh token'
        );
    }
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}
