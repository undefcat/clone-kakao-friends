<?php

namespace Undefcat\Product\Repositories;

use Illuminate\Support\Collection;

interface IProductRepository
{
    public function getNewProducts(int $count): Collection;
}
