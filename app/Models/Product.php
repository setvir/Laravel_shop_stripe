<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'image', 'price'
    ];

    // Mutator for setting the image URL
    public function setImageUrlAttribute($value)
    {
        $this->attributes['image_url'] = $value ?: 'https://fakeimg.pl/1600x900';
    }
}