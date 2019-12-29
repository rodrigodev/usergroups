<?php

namespace App\Application\Exceptions;

use Exception;

class ValidationException extends Exception
{

    public function __construct($message = 'Validation exception', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}