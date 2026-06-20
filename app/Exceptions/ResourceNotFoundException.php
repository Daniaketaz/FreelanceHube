<?php

namespace App\Exceptions;

use Exception;

class ResourceNotFoundException  extends ApiException
{
    protected int $statusCode = 404;

    protected string $errorCode = 'RESOURCE_NOT_FOUND';

    public function __construct(string $resource = 'Resource')
    {
        parent::__construct("{$resource} not found");
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}
