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

    public function wrapResponseNotArray(int $status, string $message, ?array $resource = []): JsonResponse
    {
        $result = [
            'status' => $status,
            'message' => $message
        ];

        if (!empty($resource)) {
                $result['records'] = (object) $resource['data'];

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
            'status' => 200,
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

    public static function paginate2($query, $message = 'Successfully get Data', $resourceClass = null)
    {
        $perPage = request()->input('perPage', self::$defaultPagination);
        
        if (!is_numeric($perPage) || (int)$perPage <= 0) {
            $perPage = self::$defaultPagination;
        }

        $collection = $query->paginate($perPage);
        $formattedData = $resourceClass ? $resourceClass::collection($collection) : $collection;

        return self::pagination($formattedData, $message);
    }


    public function created($data = [], $message = 'Successfully created Data')
    {
        return response()->json([
            'status' => 201,
            'message' => $message,
            'data' => $data
        ], 201);
    }

    public function alreadyExist($message)
    {
        return response()->json([
            'status' =>  409,
            'message' => $message
        ], 409);
    }

    public static function updated($message = 'Successfully updated Data')
    {
        return response()->json([
        'status' => 200,
        'message' => $message,
        ], 200);
    }


    public static function deleted($message = 'Successfully deleted Data')
    {
        return response()->json([
        'status' => 200,
        'message' => $message
        ], 200);
    }

    public static function notFound($message = 'Data not found')
    {
        return response()->json([
        'status' => 404,
        'message' => $message
        ], 404);
    }

    public static function invalidUUid($message = 'Invalid UUID format')
    {
        return response()->json([
        'status' => 400,
        'message' => $message
        ], 400);
    }

}
