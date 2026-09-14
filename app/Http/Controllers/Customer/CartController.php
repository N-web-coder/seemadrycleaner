<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('frontend.cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'option_id' => 'nullable|exists:product_options,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        $option = $request->option_id ? ProductOption::findOrFail($request->option_id) : null;
        
        $cart = session()->get('cart', []);
        
        // Unique key for the cart item based on product and selected option
        $cartKey = $product->id . '_' . ($option->id ?? 'base');
        
        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
            $cart[$cartKey]['remarks'] = $request->remarks; // Update remarks if provided
        } else {
            $unitPrice = $product->base_price + ($option ? $option->price : 0);
            $cart[$cartKey] = [
                "product_id" => $product->id,
                "name" => $product->name,
                "quantity" => $request->quantity,
                "price" => $unitPrice,
                "option_name" => $option ? $option->name : null,
                "option_id" => $option ? $option->id : null,
                "remarks" => $request->remarks,
                "image" => "https://images.unsplash.com/photo-1545173153-5ddf466baf58?auto=format&fit=crop&q=80&w=200"
            ];
        }
        
        session()->put('cart', $cart);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'cart_count' => count($cart),
                'product_name' => $product->name,
                'option_name' => $option ? $option->name : null,
                'message' => 'Added to basket'
            ]);
        }

        return redirect()->back()->with('success', 'Product added to basket successfully!');
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                $cart[$request->id]["quantity"] = $request->quantity;
                session()->put('cart', $cart);
                return response()->json(['success' => true]);
            }
        }
        return response()->json(['success' => false], 400);
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }
}
