<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    function buildSuccessResponse($data): JsonResponse
    {
        $payload['success'] = true;
        $payload['data'] = $data;
        $payload['statusCode'] = 200;
        $payload['message'] = "Operation Successful";
        return response()->json($payload);
    }

    function buildErrorResponse($message, $code): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }
}
