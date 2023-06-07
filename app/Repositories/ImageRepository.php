<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use App\Contracts\ImageRepositoryInterface;
use App\Models\Image;

class ImageRepository implements ImageRepositoryInterface
{
    public function saveImage($file): array
    {
        $path = $file->store('public/images');

        $image = Image::create([
            'path' => Storage::url($path),
        ]);

        return [
            'id' => $image->id,
            'path' => $image->path,
        ];
    }

    public function getImageById($image_id){
        return Image::find($image_id);
    }

    public function getExistingImageIds(array $imageIds)
    {
        return Image::whereIn('id', $imageIds)->pluck('id')->toArray();
    }
}


