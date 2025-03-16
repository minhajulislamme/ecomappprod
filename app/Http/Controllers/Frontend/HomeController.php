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
use App\Models\Setting;

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

        // Add Facebook Pixel ViewContent event (only if pixel ID is set)
        $pixelEvent = null;
        if (Setting::getValue('facebook_pixel_id')) {
            $pixelEvent = "fbq('track', 'ViewContent', {
                content_type: 'home',
                content_name: 'Homepage'
            });";
        }

        return view('frontend.index', compact('MainSliders', 'Banners', 'Categories', 'Subcategories', 'Products', 'flashSaleTimer', 'pixelEvent'));
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

        // Add GTM ecommerce data layer
        $gtmData = [
            'event' => 'view_item',
            'ecommerce' => [
                'currency' => 'BDT',
                'value' => $product->discount_price ?? $product->price,
                'items' => [[
                    'item_id' => $product->id,
                    'item_name' => $product->name,
                    'price' => $product->discount_price ?? $product->price,
                    'item_category' => $product->category->category_name ?? '',
                    'item_category2' => $product->subcategory->subcategory_name ?? '',
                    'discount' => $product->discount_price ? $product->price - $product->discount_price : 0,
                    'quantity' => 1
                ]]
            ]
        ];

        // Add Facebook Pixel ViewContent event (only if pixel ID is set)
        $pixelEvent = null;
        if (Setting::getValue('facebook_pixel_id')) {
            $pixelEvent = "fbq('track', 'ViewContent', {
                content_name: '" . addslashes($product->name) . "',
                content_ids: ['" . $product->id . "'],
                content_type: 'product',
                value: " . ($product->discount_price ?? $product->price) . ",
                currency: 'BDT'
            });";
        }

        return view('frontend.product.product_details', compact('product', 'Categories', 'Subcategories', 'pixelEvent', 'gtmData'));
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

        // Prepare GTM data layer for view_item_list event
        $gtmItems = [];
        foreach ($products as $product) {
            $gtmItems[] = [
                'item_id' => $product->id,
                'item_name' => $product->name,
                'price' => $product->discount_price ?? $product->price,
                'item_category' => $category->category_name,
                'item_category2' => $product->subcategory->subcategory_name ?? '',
                'discount' => $product->discount_price ? $product->price - $product->discount_price : 0
            ];
        }

        $gtmData = [
            'event' => 'view_item_list',
            'ecommerce' => [
                'item_list_id' => 'category_' . $category->id,
                'item_list_name' => $category->category_name,
                'items' => $gtmItems
            ]
        ];

        // Add Facebook Pixel ViewCategory event (only if pixel ID is set)
        $pixelEvent = null;
        if (Setting::getValue('facebook_pixel_id')) {
            $pixelEvent = "fbq('track', 'ViewCategory', {
                content_ids: " . json_encode($products->pluck('id')->toArray()) . ",
                content_type: 'product',
                content_category: '" . addslashes($category->category_name) . "'
            });";
        }

        return view('frontend.product.category_wise_products', compact('category', 'products', 'Categories', 'Subcategories', 'pixelEvent', 'gtmData'));
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

        // Prepare GTM data layer for view_item_list event
        $gtmItems = [];
        foreach ($products as $product) {
            $gtmItems[] = [
                'item_id' => $product->id,
                'item_name' => $product->name,
                'price' => $product->discount_price ?? $product->price,
                'item_category' => $product->category->category_name ?? '',
                'item_category2' => $subcategory->subcategory_name,
                'discount' => $product->discount_price ? $product->price - $product->discount_price : 0
            ];
        }

        $gtmData = [
            'event' => 'view_item_list',
            'ecommerce' => [
                'item_list_id' => 'subcategory_' . $subcategory->id,
                'item_list_name' => $subcategory->subcategory_name,
                'items' => $gtmItems
            ]
        ];

        // Prepare Facebook Pixel event for subcategory page
        $pixelEvent = null;
        if (Setting::getValue('facebook_pixel_id')) {
            $pixelEvent = "fbq('track', 'ViewCategory', {
                content_ids: " . json_encode($products->pluck('id')->toArray()) . ",
                content_type: 'product',
                content_category: '" . addslashes($subcategory->subcategory_name) . "'
            });";
        }

        return view('frontend.product.sub_category_wise_products', compact('subcategory', 'products', 'Categories', 'Subcategories', 'pixelEvent', 'gtmData'));
    }

    public function Shop()
    {
        $products = Product::where('status', 'active')->latest()->paginate(12);
        $Categories = Category::where('status', 'active')->latest()->get();
        $Subcategories = Subcategory::where('status', 'active')->latest()->get();

        // Prepare GTM data layer for view_item_list event
        $gtmItems = [];
        foreach ($products as $product) {
            $gtmItems[] = [
                'item_id' => $product->id,
                'item_name' => $product->name,
                'price' => $product->discount_price ?? $product->price,
                'item_category' => $product->category->category_name ?? '',
                'item_category2' => $product->subcategory->subcategory_name ?? '',
                'discount' => $product->discount_price ? $product->price - $product->discount_price : 0
            ];
        }

        $gtmData = [
            'event' => 'view_item_list',
            'ecommerce' => [
                'item_list_id' => 'shop',
                'item_list_name' => 'All Products',
                'items' => $gtmItems
            ]
        ];

        // Prepare Facebook Pixel event for shop page
        $pixelEvent = null;
        if (Setting::getValue('facebook_pixel_id')) {
            $pixelEvent = "fbq('track', 'ViewCategory', {
                content_ids: " . json_encode($products->pluck('id')->toArray()) . ",
                content_type: 'product',
                content_category: 'Shop'
            });";
        }

        return view('frontend.product.shop', compact('products', 'Categories', 'Subcategories', 'pixelEvent', 'gtmData'));
    }
}
