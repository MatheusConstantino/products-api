<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\ImageRepositoryInterface;

class ImageController extends Controller
{
    private $imageRepository;
    
    public function __construct(ImageRepositoryInterface $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $uploadedImage = $this->imageRepository->saveImage($request->file('image'));

        return response()->json([
            'message' => 'Imagem enviada com sucesso',
            'image_id' => $uploadedImage['id'],
            'image_path' => $uploadedImage['path']
        ]);
    }

}
