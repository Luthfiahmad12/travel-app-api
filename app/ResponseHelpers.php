<?php

use Illuminate\Http\Exceptions\HttpResponseException;

if (!function_exists('throwError')) {
    function throwErrorResponse(string $message, int $statusCode = 500)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $message
        ], $statusCode));
    }
}

if (!function_exists('SuccessResponse')) {
    function SuccessResponse($data, $message = null)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($response, 200);
    }
}

if (!function_exists('ErrorResponse')) {
    function ErrorResponse($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
