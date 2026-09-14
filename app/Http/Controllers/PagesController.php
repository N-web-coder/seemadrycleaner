<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
        $categories = Category::where('is_active', true)->take(6)->get();
        $featuredProducts = Product::where('is_active', true)->with('category')->take(8)->get();
        return view('frontend.home', compact('categories', 'featuredProducts'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        session(['captcha_result' => $num1 + $num2]);
        
        return view('frontend.contact', compact('num1', 'num2'));
    }
}
