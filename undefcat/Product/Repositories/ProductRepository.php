<?php

namespace Undefcat\Product\Repositories;

use App\Models\Product;

class ProductRepository implements IProductRepository
{
    public function getNewProducts(int $count, int $page): array
    {
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
    }

    public function insertProduct(array $data): array
    {
        $product = new Product();

        $product->price = $data['price'];
        $product->stock = $data['stock'];
        $product->currency = $data['currency'];
        $product->name = $data['name'];
        $product->content = $data['content'];

        $product->save();

        return $product->toArray();
    }

    public function deleteProduct(int $id): bool
    {
        $deleteCount = Product::where('id', '=', $id)
            ->delete();

        return $deleteCount === 1;
    }
}
