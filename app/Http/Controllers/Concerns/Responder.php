<?php
declare(strict_types=1);

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait Responder
{
    /**
     * Вернет сообщение
     */
    public function respondWithSuccess(string $message): JsonResponse
    {
        return $this->respondJson(['message' => $message]);
    }

    /**
     * Вернет json ответ
     */
    public function respondJson($data = null, int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json(['data' => $data], $status);
    }

    /**
     * Вернет пустой ответ
     */
    public function respondEmpty(): JsonResponse
    {
        return response()->json('', Response::HTTP_NO_CONTENT);
    }
}
