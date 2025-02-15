<?php

namespace App\Common;

use JsonSerializable;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    public static function successful(
        JsonSerializable $data,
        int $statusCode = Response::HTTP_OK,
        array $meta = [],
    ): JsonResponse {
        return new JsonResponse(
            [
                'data' => $data,
                'error' => [],
                'meta' => $meta,
            ],
            $statusCode
        );
    }

    public static function error(
        $error,
        int $statusCode = Response::HTTP_BAD_REQUEST,
        array $meta = []
    ): JsonResponse {
        return new JsonResponse(
            [
                'data'    => [],
                'error'   => $error,
                'meta'    => $meta,
            ],
            $statusCode
        );
    }

    public static function unavailable(): JsonResponse
    {
        return new JsonResponse(
            [
                'data' => [],
                'error' => 'Service Unavailable',
                'meta' => [],
            ],
            Response::HTTP_SERVICE_UNAVAILABLE
        );
    }
}