<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class WishlistController extends Controller
{
    public function addToWishlist(Request $request)
    {
        try {
            $productId = $request->product_id;
            $product = Product::findOrFail($productId);
            $wishlist = Session::get('wishlist', []);

            // Check if product already in wishlist
            if (isset($wishlist[$productId])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is already in your wishlist',
                    'wishlist_count' => count($wishlist),
                    'exists' => true
                ]);
            }

            // Add product to wishlist
            $wishlist[$productId] = [
                'name' => $product->name,
                'price' => (float)$product->price,
                'discount_price' => (float)$product->discount_price,
                'image' => asset($product->thumbnail_image)
            ];

            Session::put('wishlist', $wishlist);

            // Create GTM data layer for add_to_wishlist event
            $gtmData = [
                'event' => 'add_to_wishlist',
                'ecommerce' => [
                    'currency' => 'BDT',
                    'value' => $product->discount_price ?? $product->price,
                    'items' => [[
                        'item_id' => $product->id,
                        'item_name' => $product->name,
                        'price' => $product->discount_price ?? $product->price,
                        'item_category' => $product->category->category_name ?? '',
                        'item_category2' => $product->subcategory->subcategory_name ?? ''
                    ]]
                ]
            ];

            // Add Facebook Pixel Event only if Pixel ID is set
            $pixelEvent = null;
            if (Setting::getValue('facebook_pixel_id')) {
                $pixelEvent = "fbq('track', 'AddToWishlist', {
                    content_name: '" . addslashes($product->name) . "',
                    content_ids: ['" . $product->id . "'],
                    content_type: 'product',
                    value: " . ($product->discount_price ?? $product->price) . ",
                    currency: 'BDT'
                });";
            }

            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist successfully!',
                'wishlist_count' => count($wishlist),
                'gtmData' => $gtmData,
                'pixelEvent' => $pixelEvent
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to wishlist'
            ], 500);
        }
    }

    public function removeFromWishlist(Request $request)
    {
        $productId = $request->product_id;
        $wishlist = Session::get('wishlist', []);

        if (isset($wishlist[$productId])) {
            unset($wishlist[$productId]);
            Session::put('wishlist', $wishlist);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist',
            'wishlist_count' => count($wishlist),
            'wishlist' => $wishlist
        ]);
    }

    public function getWishlist()
    {
        $wishlist = Session::get('wishlist', []);

        // Add asset URL to images and product URLs
        foreach ($wishlist as $productId => &$item) {
            $item['image'] = asset($item['image']);
            $item['url'] = route('product.details', ['id' => $productId, 'slug' => $item['slug']]);
        }

        return response()->json([
            'success' => true,
            'wishlist' => $wishlist,
            'count' => count($wishlist)
        ]);
    }

    public function viewWishlist()
    {
        $Categories = Category::orderBy('category_name', 'ASC')->get();
        $Subcategories = SubCategory::orderBy('subcategory_name', 'ASC')->get();
        return view('frontend.wishlist.view_wishlist', compact('Categories', 'Subcategories'));
    }

    public function moveToCart(Request $request)
    {
        $productId = $request->product_id;
        $wishlist = Session::get('wishlist', []);
        $cart = Session::get('cart', []);

        if (isset($wishlist[$productId])) {
            $cart[$productId] = $wishlist[$productId];
            unset($wishlist[$productId]);

            Session::put('wishlist', $wishlist);
            Session::put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product moved to cart',
            'wishlist_count' => count($wishlist),
            'cart_count' => count($cart)
        ]);
    }

    public function moveAllToCart()
    {
        $wishlist = Session::get('wishlist', []);
        $cart = Session::get('cart', []);

        foreach ($wishlist as $productId => $item) {
            $cart[$productId] = $item;
        }

        Session::put('cart', $cart);
        Session::put('wishlist', []);

        return response()->json([
            'success' => true,
            'message' => 'All products moved to cart',
            'cart_count' => count($cart)
        ]);
    }
}
