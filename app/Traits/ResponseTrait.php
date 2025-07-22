<?php

namespace App\Traits;

trait ResponseTrait
{
    public static function responseJson(mixed $payload = null, ?string $message = null, int $status = 200)
    {
        $result = [];
        if (isset($message)) {
            $result['message'] = $message;
        }
        $result['payload'] = $payload;

        return response()->json($result, $status);
    }

    public static function notFoundResponse(string $message = 'Not found')
    {
        return response()->json([
            'message' => $message,
        ], 404);
    }

    public static function userErrorResponse(string $message = 'User error', int $status = 400)
    {
        return response()->json([
            'message' => $message,
        ], $status);
    }
}
