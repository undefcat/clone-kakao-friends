<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/products/new', [ProductController::class, 'newProducts'])
        ->name('products.new');

    Route::post('/products', [ProductController::class, 'storeProduct'])
        ->name('products.store');

    Route::delete('/products/{id}', [ProductController::class, 'deleteProduct'])
        ->where('id', '[0-9]+')
        ->name('products.delete');
});
