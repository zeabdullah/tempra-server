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
}
