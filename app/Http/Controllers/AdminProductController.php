<?php

namespace App\Http\Controllers;

use App\Services\AdminProductService;
use App\Http\Requests\ProductRequest;
use App\Models\Product;

class AdminProductController extends Controller
{
    public function __construct(private AdminProductService $adminProductService)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(ProductRequest $request)
    {
        $product = $this->adminProductService->storeProduct($request->validated());
        return redirect()->route('admin.products.index')->with('success',$product->name.' successfully created');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product = $this->adminProductService->updateProduct($product, $request->validated());
        return redirect()->route('admin.products.index')->with('success',$product->name.' successfully updated');
    }

    public function delete(Product $product)
    {
        $this->adminProductService->deleteProduct($product);
        return redirect()->back()->with('success',$product->name.' successfully deleted');
    }
}