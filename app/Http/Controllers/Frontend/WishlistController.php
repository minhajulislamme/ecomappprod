<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    public function addToWishlist(Request $request)
    {
        $productId = $request->product_id;
        $product = Product::findOrFail($productId);

        $wishlist = Session::get('wishlist', []);

        if (isset($wishlist[$productId])) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist',
                'wishlist_count' => count($wishlist)
            ]);
        }

        $wishlist[$productId] = [
            'name' => $product->name,
            'price' => (float)$product->price,
            'discount_price' => (float)$product->discount_price,
            'image' => $product->thumbnail_image  // Store only the path, not the full asset URL
        ];

        Session::put('wishlist', $wishlist);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist',
            'wishlist_count' => count($wishlist)
        ]);
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

        // Add asset URL to images
        foreach ($wishlist as &$item) {
            $item['image'] = asset($item['image']);
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
