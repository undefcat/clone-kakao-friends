<?php

namespace Undefcat\Product\Repositories;

interface IProductRepository
{
    public function getNewProducts(int $count, int $page): array;

    public function insertProduct(array $data): array;

    public function deleteProduct(int $id): bool;
}
