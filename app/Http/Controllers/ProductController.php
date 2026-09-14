<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['slug'] = Str::slug($validated['name']);

        $product = Product::create($validated);

        if ($request->has('options') && is_array($request->options)) {
            foreach ($request->options as $opt) {
                if (!empty($opt['name'])) {
                    $product->options()->create([
                        'name' => $opt['name'],
                        'price' => $opt['price'] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['slug'] = Str::slug($validated['name']);

        $product->update($validated);

        if ($request->has('options') && is_array($request->options)) {
            $keepIds = [];
            foreach ($request->options as $opt) {
                if (!empty($opt['name'])) {
                    if (!empty($opt['id'])) {
                        $option = $product->options()->find($opt['id']);
                        if ($option) {
                            $option->update([
                                'name' => $opt['name'],
                                'price' => $opt['price'] ?? 0,
                            ]);
                            $keepIds[] = $option->id;
                        }
                    } else {
                        $newOption = $product->options()->create([
                            'name' => $opt['name'],
                            'price' => $opt['price'] ?? 0,
                        ]);
                        $keepIds[] = $newOption->id;
                    }
                }
            }
            $product->options()->whereNotIn('id', $keepIds)->delete();
        } else {
            $product->options()->delete();
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
