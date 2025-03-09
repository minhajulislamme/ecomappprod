<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainSlider;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;

class HomeController extends Controller
{
    public function index(){

        $MainSliders = MainSlider::where('status', 'active')->latest()->get();
        $Banners = Banner::where('status', 'active')->latest()->get();
        $Categories = Category::where('status', 'active')->latest()->get();
        // $Subcategories = Subcategory::where('status', 'active')->latest()->get();
        $Products = Product::where('status', 'active')->latest()->get();
        return view('frontend.index', compact('MainSliders', 'Banners','Categories', 'Products'));
    }
}
// , 'Subcategories', 