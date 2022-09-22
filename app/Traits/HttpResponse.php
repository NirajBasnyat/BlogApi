<?php

namespace App\Traits;

use Auth;
use Illuminate\Http\JsonResponse;

trait HttpResponse
{
    public function successResponse($data, $message = null, $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'Response Successful',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function errorResponse($data, $message = null, $code = 400): JsonResponse
    {
        return response()->json([
            'status' => 'Response Error',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function checkAuthorizedUser($model, $column = 'user_id'): bool
    {
        if ($model->{$column} == Auth::guard('sanctum')->user()->id) {
            return true;
        }

        return false;
    }
}