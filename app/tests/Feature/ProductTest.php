<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;
use App\Http\Controllers\ProductController;

class ProductTest extends TestCase
{
    public function testIndexProductController() : void
    {
        $product = $this->mockProduct(10);
        $listProducts = $this->get('/api/products');
        $data = json_decode($listProducts->getContent(), true)['data'];
        $this->assertEquals('10', count($data));
    }

    public function testStoreProductController() : void
    {
        $productAttributes = [
            'name' => 'produit',
            'description' => 'description du produit',
            'photo' => 'url de la photo',
            'price' => '100',
        ];

        $this->post('/api/products', $productAttributes);
        $product = Product::first();

        $this->assertEquals('produit description du produit url de la photo 100',
                            $product->name." ".$product->description." ".$product->photo." ".$product->price);
    }

    public function testShowProductController() : void
    {
        $productAttributes = [
            'name' => 'produit',
            'description' => 'description du produit',
            'photo' => 'url de la photo',
            'price' => '100',
        ];

        $this->post('/api/products', $productAttributes);
        $data = $this->get('/api/products/1');
        $product = json_decode($data->getContent(), true)['data'];
        $this->assertEquals('produit description du produit url de la photo 100',
                            $product['name']." ".$product['description']." ".$product['photo']." ".$product['price']);
    }

    public function testUpdateProductController() : void
    {
        $productAttributes = [
            'name' => 'produit',
            'description' => 'description du produit',
            'photo' => 'url de la photo',
            'price' => '100',
        ];       
        $this->mockProduct(1, $productAttributes);
        
        $productAttributes['name'] = 'changed';
        $this->patch('/api/products/1', $productAttributes);
        $product = Product::first();
        
        $this->assertEquals('changed', $product->name);
    }

    public function testDestroyProductController() : void
    {
        $productAttributes = [
            'name' => 'produit',
            'description' => 'description du produit',
            'photo' => 'url de la photo',
            'price' => '100',
        ];
        
        $this->mockProduct(1, $productAttributes);
        $product = Product::first();

        $product->delete('/api/products/1');

        $this->assertEquals(0, Product::count());
    }
}