<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function categories()
    {
        $categories = Category::where('is_active', true)->withCount('products')->get();
        return view('frontend.categories.index', compact('categories'));
    }

    public function categoryProducts(Category $category)
    {
        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->with(['category', 'options'])
            ->latest()
            ->paginate(12);
            
        return view('frontend.products.index', compact('category', 'products'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'options']);
        
        // Suggested products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }
}
