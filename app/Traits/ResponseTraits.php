<?php

namespace App\Traits;

use Illuminate\Container\Container;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;


trait ResponseTraits
{
    public function successResponse(mixed $data, string $message, int $status_code = 200)
    {
        return response()->json(['success' => true,'data' => $data, 'message' => $message], $status_code);
    }

    public function errorResponse(string $message, int $status_code = 401)
    {
        return response()->json(['success' => false, 'message' => $message], $status_code);
    }

    protected function responseJson(mixed $data, string $message = '', int $responseCode = Response::HTTP_OK, bool $status = true): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'statusCode' => $responseCode,
        ], $responseCode);
    }

}
