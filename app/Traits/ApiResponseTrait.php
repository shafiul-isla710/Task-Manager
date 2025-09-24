<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait 
{
     protected function success(mixed $data = null, string $message = 'Success', int $code = 200):JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ],$code);
    }

    protected function error(array $messages = ['Internal Server Error'], int $code = 500):JsonResponse
    {
        return response()->json([
            'status' => false,
            'messages' => $messages,
            
        ],$code);
    }
}
