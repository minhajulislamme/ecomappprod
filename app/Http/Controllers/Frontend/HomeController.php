<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainSlider;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;

use function Ramsey\Uuid\v1;

class HomeController extends Controller
{
    public function index()
    {

        $MainSliders = MainSlider::where('status', 'active')->latest()->get();
        $Banners = Banner::where('status', 'active')->latest()->get();
        $Categories = Category::where('status', 'active')->latest()->get();
        $Subcategories = Subcategory::where('status', 'active')->latest()->get();
        $Products = Product::where('status', 'active')->latest()->get();
        return view('frontend.index', compact('MainSliders', 'Banners', 'Categories', 'Subcategories', 'Products',));
    }

    public function ProductDetails($id, $slug)
    {
        $product = Product::findOrFail($id);

        // Redirect if slug doesn't match
        if ($product->slug !== $slug) {
            return redirect()->route('product.details', ['id' => $product->id, 'slug' => $product->slug]);
        }

        $Categories = Category::where('status', 'active')->latest()->get();
        $Subcategories = Subcategory::where('status', 'active')->latest()->get();
        return view('frontend.product.product_details', compact('product', 'Categories', 'Subcategories'));
    }
}
