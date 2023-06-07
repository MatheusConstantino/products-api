<?php

namespace App\Http\Controllers;

use App\Contracts\ImageRepositoryInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $productRepository;
    private $imageRepository;

    public function __construct(ProductRepositoryInterface $productRepository, ImageRepositoryInterface $imageRepository)
    {
        $this->productRepository = $productRepository;
        $this->imageRepository = $imageRepository;
    }

    public function index()
    {
        $products = $this->productRepository->getAllProducts();

        $formattedProducts = $products->map(function ($product) {
            $images = $product->images->map(function ($image) {
                return [
                    'image_id' => $image->id,
                    'image_path' => $image->path,
                ];
            });

            return [
                'id' => $product->id,
                'name' => $product->name,
                'isbn' => $product->isbn,
                'price' => $product->price,
                'images' => $images,
            ];
        });

        $pagination = $products->toArray();

        $response = [
            'data' => $formattedProducts,
            'pagination' => [
                'total' => $pagination['total'],
                'per_page' => $pagination['per_page'],
                'current_page' => $pagination['current_page'],
                'last_page' => $pagination['last_page'],
            ],
        ];

        return response()->json($response);
    }
    public function store(CreateProductRequest $request)
    {
        $validatedData = $request->validated();
        $imageIds = $validatedData['image_ids'];
        unset($validatedData['image_ids']);

        $product = $this->productRepository->createProduct($validatedData);

        if (!empty($imageIds)) {
            $existingImageIds = $this->imageRepository->getExistingImageIds($imageIds);
            $product->images()->sync($existingImageIds);
        }

        return response()->json($product, 201);
    }

    public function show($id)
    {
        $product = $this->productRepository->getProductById($id);

        return response()->json($product);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $validatedData = $request->validated();
        $imageIds = $validatedData['image_ids'];
        unset($validatedData['image_ids']);

        $product = $this->productRepository->updateProduct($id, $validatedData);

        if (!empty($imageIds)) {
            $existingImageIds = $this->imageRepository->getExistingImageIds($imageIds);
            $product->images()->sync($existingImageIds);
        } else {
            $product->images()->detach();
        }

        return response()->json($product, 200);
    }

    public function destroy($id)
    {
        $product = $this->productRepository->getProductById($id);

        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $this->productRepository->deleteProduct($id);

        return response()->noContent();
    }
}

