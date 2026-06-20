<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedActionException extends ApiException
{
    protected int $statusCode = 403;
    protected string $errorCode = 'USER_NOT_AUTHORIZED';
    public function __construct()
    {
        parent::__construct(
            'You are not authorized to perform this action'
        );
    }
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}
