<?php

namespace App\Contracts;

interface ImageRepositoryInterface
{
    public function saveImage($file): array;
    public function getImageById($image_id);
    public function getExistingImageIds(array $imageIds);
}
