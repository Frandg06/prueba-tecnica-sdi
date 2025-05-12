<?php

namespace App\Exceptions;

use Exception;

class SpotifyException extends Exception
{
    public function __construct($message, $code = 0, $previous = null, $var = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
