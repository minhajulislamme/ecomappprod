<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainSlider;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\FlashSelasTimer;

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
        $flashSaleTimer = FlashSelasTimer::where('status', 'active')->first();
        return view('frontend.index', compact('MainSliders', 'Banners', 'Categories', 'Subcategories', 'Products', 'flashSaleTimer'));
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

    public function ProductCategory($id, $slug)
    {
        $category = Category::findOrFail($id);

        // Redirect if slug doesn't match
        if ($category->category_slug !== $slug) {
            return redirect()->route('product.category', ['id' => $category->id, 'slug' => $category->category_slug]);
        }

        $products = Product::where('category_id', $id)->where('status', 'active')->latest()->paginate(12);
        $Categories = Category::where('status', 'active')->latest()->get();
        $Subcategories = Subcategory::where('status', 'active')->latest()->get();

        return view('frontend.product.category_wise_products', compact('category', 'products', 'Categories', 'Subcategories'));
    }

    public function ProductSubCategory($id, $slug = null)
    {
        $subcategory = Subcategory::findOrFail($id);

        // Redirect if slug doesn't match and slug is provided
        if ($slug !== null && $subcategory->subcategory_slug !== $slug) {
            return redirect()->route('product.subcategory', ['id' => $subcategory->id, 'slug' => $subcategory->subcategory_slug]);
        }

        $products = Product::where('subcategory_id', $id)->where('status', 'active')->latest()->paginate(12);
        $Categories = Category::where('status', 'active')->latest()->get();
        $Subcategories = Subcategory::where('status', 'active')->latest()->get();

        return view('frontend.product.sub_category_wise_products', compact('subcategory', 'products', 'Categories', 'Subcategories'));
    }

    public function Shop()
    {
        $products = Product::where('status', 'active')->latest()->paginate(2); // Changed to paginate 12 products per page
        $Categories = Category::where('status', 'active')->latest()->get();
        $Subcategories = Subcategory::where('status', 'active')->latest()->get();

        return view('frontend.product.shop', compact('products', 'Categories', 'Subcategories'));
    }
}
