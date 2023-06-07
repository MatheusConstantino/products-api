<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price', 'isbn', 'status', 'image_id'
    ];

    public function images()
    {
        return $this->belongsToMany(Image::class, 'product_images');
    }
}
