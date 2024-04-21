<?php
namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait {
    public function responseWithSuccess ($data = [], $code = 200): JsonResponse {
        return response()->json(
            [
                'data' => $data,
                'code' => $code
            ]
        );
    }

    public function responseWithError ($message = 'Error response', $code = 500): JsonResponse {
        return response()->json(
            [
                'message' => $message,
                'code' => $code
            ]
        );
    }

    public function responseWithNotFound (): JsonResponse {
        return response()->json(
            [
                'code' => 404,
                'message' => 'Not found'
            ]
        );
    }
}
