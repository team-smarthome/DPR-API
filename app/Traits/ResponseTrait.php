<?php

namespace App\Traits;

use ErrorException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

trait ResponseTrait
{
  public function wrapResponse(int $status, string $message, ?array $resource = []): JsonResponse
  {
    $result = [
      'status' => $status,
      'message' => $message
    ];

    if (count($resource)) {
      $result = array_merge($result, ['records' => $resource['data']]);

      if (count($resource) > 1)
        $result = array_merge($result, ['pages' => ['links' => $resource['links'], 'meta' => $resource['meta']]]);
    }

    return response()->json($result, $status);
  }
}
