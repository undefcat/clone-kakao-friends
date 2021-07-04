<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class MorphMapServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Relation::morphMap([
            'product' => Product::class,
        ]);
    }
}
