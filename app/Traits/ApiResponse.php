<?php

namespace app\Traits;

trait ApiResponse
{
    protected function defaultJsonResponse($success, $title, $message = "", $messages = [], $data = null, $code = 200)
    {
        return response()->json([
            "success" => $success,
            "title" => $title,
            "message" => $message,
            "messages" => $messages,
            "data" => $data,
            "code" => $code,
        ], $code);
    }
    
    protected function defaultJsonResponseWithoutData($success, $title, $message = "", $messages = [], $code = 200)
    {
        return response()->json([
            "success" => $success,
            "title" => $title,
            "message" => $message,
            "messages" => $messages,
            "data" => null,
            "code" => $code,
        ], $code);
    }
    
}
