<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\NewProductResource;
use Illuminate\Http\JsonResponse;
use Throwable;
use Undefcat\Product\Services\ProductService as Service;

class ProductController extends Controller
{
    /**
     * @param Service $service
     * @return JsonResponse
     */
    public function newProducts(Service $service): JsonResponse
    {
        $data = $service->getProductList(20);

        return response()->json([
            'data' => NewProductResource::collection($data['items']),
            'paging' => $data['paging'],
        ]);
    }

    /**
     * @param Service $service
     * @param ProductStoreRequest $request
     * @return JsonResponse
     */
    public function storeProduct(Service $service, ProductStoreRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $newProduct = $service->saveProduct($data);

            return response()->json(null, 201);

        } catch (Throwable $e) {

            return response()->json(null, 500);
        }
    }

    /**
     * @param Service $service
     * @param int $id
     * @return JsonResponse
     */
    public function deleteProduct(Service $service, int $id): JsonResponse
    {
        try {
            $ok = $service->deleteProduct($id);

            $responseCode = $ok ? 204 : 404;

            return response()->json(null, $responseCode);

        } catch (Throwable $e) {
            return response()->json(null, 500);
        }
    }
}
