<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ApiException extends Exception
{
    public function __construct($message, $code = 0, $previous = null, $var = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render($request): JsonResponse
    {
        return response()->json([
            'error' => true,
            'message' => $this->getMessage() ?: __('i18n.unexpected_error'),
        ], 500);
    }
}
