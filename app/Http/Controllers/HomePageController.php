<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomePageController extends Controller
{

    /**
     * Show the application landing/welcome page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(12);
        session(['page' => $request->get('page', 1)]);
        return view('welcome', compact('products'));
    }
}