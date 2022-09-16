<?php

namespace App\Services;

class Responser
{
    public static function jsonResponse(bool $status, $data = null, string $message = null)
    {
        return [
            'status' => $status,
            'data' => $data,
            'message' => $message
        ];
    }
}
