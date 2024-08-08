<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class AdminProductService
{

    public function storeProduct(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->uploadImage($data['image']);
        }
        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data)
    {
        if (isset($data['image'])) {
            $this->deleteImage($product->image);
            $data['image'] = $this->uploadImage($data['image']);
        }
        $product->update($data);
        $product->save();
        return  $product;
    }

    public function deleteProduct(Product $product)
    {
        $this->deleteImage($product->image);
        $product->delete();
    }

    protected function uploadImage($image)
    {
        // Store the image and return the path
        return $image->store('images/products', 'public');
    }

    protected function deleteImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
