<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    public static $defaultPagination = 10;

    public function wrapResponse(int $status, string $message, ?array $resource = []): JsonResponse
    {
        $result = [
            'status' => $status,
            'message' => $message
        ];

        if (!empty($resource)) {
            $result = array_merge($result, ['records' => $resource['data']]);

            if (count($resource) > 1) {
                $result = array_merge($result, ['pages' => ['links' => $resource['links'], 'meta' => $resource['meta']]]);
            }
        }

        return response()->json($result, $status);
    }

    public function success($data = [], $message = 'Success'): JsonResponse
    {
        return $this->wrapResponse(200, $message, ['data' => $data]);
    }

    public static function pagination($collection, $message = 'Successfully get Data')
    {
        if ($collection->isEmpty()) {
            return (new self)->success([], 'Data not found.');
        }
        
        $paginationData = [
            'currentPage' => $collection->currentPage(),
            'pageSize' => $collection->perPage(),
            'from' => $collection->firstItem(),
            'to' => $collection->lastItem(),
            'totalRecords' => $collection->total(),
            'totalPages' => $collection->lastPage(),
        ];

        return response()->json([
            'status' => 'OK',
            'message' => $message,
            'records' => $collection->items(),
            'pagination' => $paginationData,
        ], 200);
    }

    public static function paginate($query, $max_data = null, $message = 'Successfully get Data', $perPage = null)
    {
        $perPage = request()->input('perPage', $perPage ?? self::$defaultPagination);
        
        if (!is_numeric($perPage) || (int)$perPage <= 0) {
            $perPage = self::$defaultPagination;
        }

        $collection = $query->paginate($perPage);
        return self::pagination($collection, $message);
    }

    public function created($data = [], $message = 'Successfully created Data')
    {
        return response()->json([
            'status' => 'OK',
            'message' => $message,
            'data' => $data
        ], 201);
    }


}
