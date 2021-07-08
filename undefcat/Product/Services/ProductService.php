<?php

namespace Undefcat\Product\Services;

use App\Models\File;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        $default = [
            'items' => [],
            'paging' => [
                'current' => 1,
                'next' => 1,
            ],
        ];

        if ($count <= 0) {
            return $default;
        }

        try {
            $paginator = Product::orderBy('created_at', 'DESC')
                ->paginate($count);

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
            return $default;
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

            collect($data['images'])->each(function ($image) use ($product) {
                /** @var UploadedFile $image */

                $path = Storage::disk('public')->put('products', $image);
                [$mimeType, $mimeSubtype] = explode('/', $image->getMimeType());

                $file = new File();

                $file->size = $image->getSize();
                $file->tag = 'image';
                $file->mime_type = $mimeType;
                $file->mime_subtype = $mimeSubtype;
                $file->original_name = $image->getClientOriginalName();
                $file->path = $path;

                $product->files()->save($file);
            });

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
