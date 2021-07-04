<?php

namespace Undefcat\Product\Services;

use Throwable;
use Undefcat\Product\Repositories\IProductRepository;

class ProductService
{
    public function __construct(
        private IProductRepository $repo,
    ) {}

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
            return $this->repo->getNewProducts($count, $page);

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
            $product = $this->repo->insertProduct($data);

            return $product;

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
            return $this->repo->deleteProduct($id);

        } catch (Throwable $e) {

            return false;
        }
    }
}
