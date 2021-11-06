<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 */
trait ApiResponseTrait
{
    /**
     * responseSuccessJson
     *
     * @param JsonResource $resource
     * @param mixed $message
     * @param mixed $errors
     * @param mixed $statusCode
     * @return JsonResponse
     */
    protected function responseSuccessJson(JsonResource $resource = null, $message = null, $errors = null, $statusCode = 200)
    {
        return response()->json(
            [
                'success' => true,
                'message' => $message,
                'errors' => $errors,
                'code' => $statusCode,
                'data' => !empty($resource) ? $resource->toArray(request()) : null,
            ], $statusCode
        );
    }

    /**
     * responseFailJson
     *
     * @param mixed $message
     * @param mixed $errors
     * @param mixed $statusCode
     * @return void
     */
    protected function responseFailJson($message = null, $errors = null, $statusCode = 200)
    {
        return response()->json(
            [
                'success' => false,
                'message' => $message,
                'errors' => $errors,
                'code' => $statusCode,
                'data' => null,
            ], $statusCode
        );
    }
}
