<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $statusCode;
    protected $customType;

    public function __construct($message = '', $statusCode = 400, $customType = null, $code = 0, Exception $previous = null)
    {
        $this->statusCode = $statusCode;
        $this->customType = $customType;

        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getCustomType()
    {
        return $this->customType;
    }
}
