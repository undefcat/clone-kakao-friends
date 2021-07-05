<?php

namespace Undefcat\Product\Services;

use App\Models\Product;
use Throwable;

class ProductService
{
    /**
     * 새로운 상품 목록을 가져온다.
     *
     * @param int $count
     * @param int $page
     * @return array
     */
    public function getProductList(int $count, int $page = 1): array
    {
        if ($count <= 0) {
            return [];
        }

        try {
            $paginator = Product::paginate($count);

            $current = $paginator->currentPage();

            return [
                'items' => $paginator->items(),
                'paging' => [
                    'current' => $current,
                    'next' => $paginator->hasMorePages()
                        ? $current + 1
                        : $current
                ],
            ];

        } catch (Throwable $e) {
            return [];
        }
    }

    /**
     * 새로운 상품을 저장한다.
     *
     * @param array $data
     * @return array
     */
    public function saveProduct(array $data): array
    {
        try {
            $product = new Product();

            $product->price = $data['price'];
            $product->stock = $data['stock'];
            $product->currency = $data['currency'];
            $product->name = $data['name'];
            $product->content = $data['content'];

            $product->save();

            return $product->toArray();

        } catch (Throwable $e) {
            return [];
        }
    }

    /**
     * 상품을 삭제한다.
     *
     * @param int $id
     * @return bool
     */
    public function deleteProduct(int $id): bool
    {
        try {
            $deleteCount = Product::where('id', '=', $id)
                ->delete();

            return $deleteCount === 1;

        } catch (Throwable $e) {

            return false;
        }
    }
}
