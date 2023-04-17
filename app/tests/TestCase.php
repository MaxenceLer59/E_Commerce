<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use \App\Models\Product;

abstract class TestCase extends BaseTestCase
{
    // php artisan make:test UserTest
    use CreatesApplication;
    use RefreshDatabase;

    public function mockProduct($nb=1)
    {
        return Product::factory($nb)->create();
    }
}
