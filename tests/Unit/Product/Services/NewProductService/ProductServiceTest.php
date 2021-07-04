<?php

namespace Tests\Unit\Product\Services\NewProductService;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Undefcat\Product\Repositories\IProductRepository;
use Undefcat\Product\Services\ProductService;

class ProductServiceTest extends TestCase
{
    private ProductService $service;

    private m\MockInterface $mock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = m::mock(IProductRepository::class);
        $this->service = new ProductService($this->mock);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        m::close();
    }

    public function test_get_products_with_zero_count(): void
    {
        $count = 0;

        $this->mock->shouldNotReceive('getNewProducts');

        $newProducts = $this->service->getProductList($count);

        $this->assertIsArray($newProducts);
        $this->assertCount(0, $newProducts);
    }

    public function test_get_products_with_positive_count(): void
    {
        $count = 20;

        $this->mock->shouldReceive('getNewProducts')
            ->once()
            ->andReturn(array_fill(0, $count, null));

        $newProducts = $this->service->getProductList($count);

        $this->assertIsArray($newProducts);
        $this->assertCount($count, $newProducts);
    }

    public function test_get_products_with_negative_count(): void
    {
        $count = -1;

        $this->mock->shouldNotReceive('getNewProducts');
        $newProducts = $this->service->getProductList($count);

        $this->assertIsArray($newProducts);
        $this->assertCount(0, $newProducts);
    }

    public function test_insert_product()
    {
        $data = [
            'price' => 12345,
            'stock' => 100,
            'currency' => 'KRW',
            'name' => 'Product',
            'content' => 'Content',
        ];

        $this->mock->shouldReceive('insertProduct')
            ->once()
            ->andReturn(array_merge($data, ['id' => 1]));

        $product = $this->service->saveProduct($data);

        $this->assertIsArray($product);
        $this->assertArrayHasKey('id', $product);
    }

    public function test_delete_product()
    {
        $this->mock->shouldReceive('deleteProduct')
            ->once()
            ->andReturnTrue();

        $this->assertTrue($this->service->deleteProduct(1));
    }
}
