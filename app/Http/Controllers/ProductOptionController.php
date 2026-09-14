<?php

namespace App\Http\Controllers;

use App\Models\ProductOption;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductOptionController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductOption::with('product')->latest();
        $product = null;

        if ($request->has('product_id')) {
            $query->where('product_id', $request->product_id);
            $product = Product::find($request->product_id);
        }

        $options = $query->paginate(20);
        return view('admin.product_options.index', compact('options', 'product'));
    }

    public function create(Request $request)
    {
        $product = null;
        if ($request->has('product_id')) {
            $product = Product::find($request->product_id);
        }
        $products = Product::where('is_active', true)->get();
        return view('admin.product_options.create', compact('products', 'product'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);

        ProductOption::create($validated);
        return redirect()->route('admin.product-options.index', ['product_id' => $request->product_id])->with('success', 'Product Option created successfully.');
    }

    public function edit($id)
    {
        $productOption = ProductOption::findOrFail($id);
        $products = Product::where('is_active', true)->get();
        return view('admin.product_options.edit', compact('productOption', 'products'));
    }

    public function update(Request $request, $id)
    {
        $productOption = ProductOption::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);

        $productOption->update($validated);
        return redirect()->route('admin.product-options.index', ['product_id' => $productOption->product_id])->with('success', 'Product Option updated successfully.');
    }

    public function destroy($id)
    {
        $productOption = ProductOption::findOrFail($id);
        $productId = $productOption->product_id;
        $productOption->delete();
        return redirect()->route('admin.product-options.index', ['product_id' => $productId])->with('success', 'Product Option deleted successfully.');
    }
}
