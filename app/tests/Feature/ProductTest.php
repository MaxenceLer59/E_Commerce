<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testProduct() : void
    {
        $product = $this->mockProduct(10);
        $this->assertEquals(10, $product->count());
    }
}
