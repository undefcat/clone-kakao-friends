<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'price' => ['required', 'integer'],
            'stock' => ['required', 'integer'],
            'currency' => ['nullable', 'size:3'],
            'name' => ['required', 'max:60'],
            'content' => ['nullable'],
        ];
    }

    public function attributes()
    {
        return [
            'price' => '가격',
            'stock' => '재고',
            'currency' => '기준통화',
            'name' => '상품명',
            'content' => '상품설명',
        ];
    }
}
