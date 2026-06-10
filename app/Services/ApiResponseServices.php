<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ApiResponseServices
{
    public function success(mixed $data, string $message = 'Success', int $statusCode = 200):JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);

    }
    public function failure(string $message = 'Failure', array $errors = [], int $statusCode = 400):JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errors))
        {
            $response['errors'] = $errors;
        }
        return response()->json($response, $statusCode);
    }
}
