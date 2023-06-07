<?php

namespace Tests\Unit;

use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function createAuthenticatedUser()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $token = auth()->login($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function testGetAllProducts()
    {
        $authenticatedUser = $this->createAuthenticatedUser();

        $response = $this->get('/api/products', [
            'Authorization' => 'Bearer ' . $authenticatedUser['token'],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [],
        ]);
    }

    public function testCreateProduct()
    {
        $authenticatedUser = $this->createAuthenticatedUser();

        $image1 = Image::create([
            'path' => 'url_da_imagem1',
        ]);

        $image2 = Image::create([
            'path' => 'url_da_imagem2',
        ]);


        $productData = [
            'name' => 'Product 1',
            'price' => 10.99,
            'isbn' => '1234567890',
            'image_ids' => [$image1->id, $image2->id],
        ];

        $response = $this->post('/api/products', $productData, [
            'Authorization' => 'Bearer ' . $authenticatedUser['token'],
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'name' => $productData['name'],
            'price' => $productData['price'],
            'isbn' => $productData['isbn'],
        ]);
    }

    public function testShowProduct()
    {
        $authenticatedUser = $this->createAuthenticatedUser();
        $product = Product::factory()->create();

        $response = $this->get('/api/products/' . $product->id, [
            'Authorization' => 'Bearer ' . $authenticatedUser['token'],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'name' => $product->name,
            'price' => $product->price,
        ]);
    }

    public function testUpdateProduct()
    {
        $authenticatedUser = $this->createAuthenticatedUser();
        $product = Product::factory()->create();

        $image1 = Image::create([
            'path' => 'url_da_imagem1',
        ]);

        $image2 = Image::create([
            'path' => 'url_da_imagem2',
        ]);

        $productData = [
            'name' => 'Updated Product',
            'price' => 20.99,
            'isbn' => '12345678900',
            'image_ids' => [$image1->id, $image2->id],
        ];

        $response = $this->put('/api/products/' . $product->id, $productData, [
            'Authorization' => 'Bearer ' . $authenticatedUser['token'],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'name' => $productData['name'],
            'price' => $productData['price'],
            'isbn' => $productData['isbn'],
        ]);
    }

    public function testDeleteProduct()
    {
        $authenticatedUser = $this->createAuthenticatedUser();
        $product = Product::factory()->create();

        $response = $this->delete('/api/products/' . $product->id, [], [
            'Authorization' => 'Bearer ' . $authenticatedUser['token'],
        ]);

        $response->assertStatus(204);
    }
}
