<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Product;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // 50개 insert
        $this->seed(ProductSeeder::class);
    }

    public function test_new_product_list()
    {
        $res = $this->getJson(route('products.new'));

        $this->assertNewProductListStatusAndJsonStructure($res, 1);
    }

    public function test_new_product_list_with_paging()
    {
        $currentPage = 2;

        $res = $this->getJson(
            route('products.new', ['page' => $currentPage])
        );

        $this->assertNewProductListStatusAndJsonStructure($res, $currentPage);
        $res->assertJson(fn (AssertableJson $json) =>
            $json->where('paging.next', $currentPage+1)
                ->etc()
        );
    }

    /**
     * 유효하지 않은 page parameter를 받는 경우, 기본값으로 1 page를 응답한다.
     */
    public function test_new_product_list_with_invalid_paging()
    {
        $invalidParams = [
            -1, 0, 0.55, 'string', 'null', 'undefined',
        ];

        foreach ($invalidParams as $page) {
            $res = $this->getJson(
                route('products.new', ['page' => $page])
            );

            $this->assertNewProductListStatusAndJsonStructure($res, 1);
        }
    }

    /**
     * 마지막 페이지의 경우, paging.next 값이 현재 page 값과 같아야 한다.
     */
    public function test_new_product_list_last_paging()
    {
        // 20개씩 50개의 아이템이 있으므로
        // 3page가 마지막이다.
        $page = 3;

        $res = $this->getJson(
            route('products.new', ['page' => $page])
        );

        $this->assertNewProductListStatusAndJsonStructure($res, $page);
        $res->assertJson(fn (AssertableJson $json) =>
            $json->where('paging.next', $page)
                ->etc()
        );
    }

    /**
     * @param TestResponse $response
     * @param int $currentPaging
     */
    private function assertNewProductListStatusAndJsonStructure(
        TestResponse $response,
        int $currentPaging,
    ) {
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'paging' => [
                'current', 'next',
            ],
        ]);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('paging.current', $currentPaging)
                ->etc()
        );
    }

    public function test_insert_product()
    {
        $data = [
            'price' => 10000,
            'stock' => 10,
            'currency' => 'KRW',
            'name' => 'TITLE',
            'content' => 'DESCRIPTION',
        ];

        $res = $this->json(
            'POST', route('products.store'), $data,
        );

        $res->assertStatus(201);
    }

    public function test_insert_product_empty_data()
    {
        $requiredFields = [
            'price', 'stock', 'name',
        ];

        $emptyData = [];

        $res = $this->json(
            'POST', route('products.store'), $emptyData,
        );

        $res->assertJsonValidationErrors($requiredFields);
    }

    public function test_delete_product()
    {
        $id = 10;

        $res = $this->json(
            'DELETE', route('products.delete', ['id' => $id]),
        );

        $res->assertStatus(204);

        $find = Product::find($id);

        $this->assertEmpty($find);
    }

    public function test_delete_product_not_exist()
    {
        $id = 9999;

        $find = Product::find($id);

        $this->assertEmpty($find);

        $res = $this->json(
            'DELETE', route('products.delete', ['id' => $id]),
        );

        $res->assertNotFound();
    }
}
