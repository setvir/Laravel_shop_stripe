<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::find($id);

        if($product)
        {
            $page = session('page', 1);
            return view('products.show', compact('product','page'));
        }

        return redirect()->route('home')->with('error',"This product can not be found, please try again.");
    }
}