<?php

namespace Undefcat\Product\Services;

use Undefcat\Product\Repositories\IProductRepository;

class NewProductService
{
    public function __construct(
        private IProductRepository $repo,
    ) {}

    /**
     * 새로운 상품 목록을 가져온다.
     *
     * @param int $count
     * @return array
     */
    public function getProductList(int $count): array
    {
        if ($count <= 0) {
            return [];
        }

        $products = $this->repo->getNewProducts($count);

        return $products->toArray();
    }
}
