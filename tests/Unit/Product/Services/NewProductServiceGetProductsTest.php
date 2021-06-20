<?php

namespace Tests\Unit\Product\Services;

use PHPUnit\Framework\TestCase;
use Undefcat\Product\Repositories\IProductRepository;
use Undefcat\Product\Services\NewProductService;
use Mockery as m;

class NewProductServiceGetProductsTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        m::close();
    }

    public function test_get_products_with_zero_count(): void
    {
        $count = 0;

        $mock = m::mock(IProductRepository::class);
        $mock->shouldNotReceive('getNewProducts');

        $service = new NewProductService($mock);

        $newProducts = $service->getProductList($count);

        $this->assertIsArray($newProducts);
        $this->assertCount(0, $newProducts);
    }

    public function test_get_products_with_positive_count(): void
    {
        $count = 20;

        $mock = m::mock(IProductRepository::class);
        $mock->shouldReceive('getNewProducts')
            ->once()
            ->andReturn(collect(array_fill(0, $count, null)));

        $service = new NewProductService($mock);

        $newProducts = $service->getProductList($count);

        $this->assertIsArray($newProducts);
        $this->assertCount($count, $newProducts);
    }

    public function test_get_products_with_negative_count(): void
    {
        $count = -1;

        $mock = m::mock(IProductRepository::class);
        $mock->shouldNotReceive('getNewProducts');

        $service = new NewProductService($mock);

        $newProducts = $service->getProductList($count);

        $this->assertIsArray($newProducts);
        $this->assertCount(0, $newProducts);
    }
}
