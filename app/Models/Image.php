<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['path'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_images');
    }
}
