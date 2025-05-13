<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class SpotifyException extends Exception
{
    protected int $status;

    public function __construct($message, $code = 0, $previous = null, $var = null)
    {
        parent::__construct($message, $code, $previous);
        $this->status = $code;
    }

    public function render($request): JsonResponse
    {
        return response()->json(
            [
                'message' => __('i18n.spotify_error'),
                'error' => [
                    'status' => $this->status,
                    'message' => $this->getMessage(),
                ],
            ],
            $this->status
        );
    }
}
