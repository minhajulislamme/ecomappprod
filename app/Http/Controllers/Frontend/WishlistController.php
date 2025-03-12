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
        try {
            $productId = $request->input('product_id');
            if (!$productId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product ID is required'
                ], 400);
            }

            $product = Product::findOrFail($productId);
            $wishlist = Session::get('wishlist', []);

            // Check if product already exists in wishlist
            if (isset($wishlist[$productId])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product already in wishlist'
                ], 400);
            }

            // Add new product to wishlist
            $price = $product->discount_price && $product->discount_price < $product->price
                ? $product->discount_price
                : $product->price;

            $wishlist[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $price,
                'image' => asset($product->thumbnail_image)
            ];

            Session::put('wishlist', $wishlist);

            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist successfully!',
                'wishlist_count' => count($wishlist)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to wishlist'
            ], 500);
        }
    }

    public function getWishlist()
    {
        $wishlist = Session::get('wishlist', []);
        return response()->json([
            'success' => true,
            'wishlist' => $wishlist
        ]);
    }

    public function removeFromWishlist(Request $request)
    {
        try {
            $productId = $request->product_id;
            $wishlist = Session::get('wishlist', []);

            if (isset($wishlist[$productId])) {
                unset($wishlist[$productId]);
                Session::put('wishlist', $wishlist);
                Session::save(); // Explicitly save the session

                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from wishlist!',
                    'wishlist_count' => count($wishlist)
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Product not found in wishlist!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove product from wishlist!'
            ], 500);
        }
    }

    public function viewWishlist()
    {
        $wishlist = Session::get('wishlist', []);
        $Categories = Category::where('status', 'active')->latest()->get();
        $Subcategories = SubCategory::where('status', 'active')->latest()->get();

        return view('frontend.wishlist.view_wishlist', compact('wishlist', 'Categories', 'Subcategories'));
    }

    public function moveToCart(Request $request)
    {
        try {
            $productId = $request->product_id;
            $wishlist = Session::get('wishlist', []);
            $cart = Session::get('cart', []);

            if (!isset($wishlist[$productId])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in wishlist!'
                ]);
            }

            // Add to cart if not already present
            if (!isset($cart[$productId])) {
                $cart[$productId] = $wishlist[$productId];
                $cart[$productId]['quantity'] = 1;
            }

            // Remove from wishlist
            unset($wishlist[$productId]);

            Session::put('cart', $cart);
            Session::put('wishlist', $wishlist);
            Session::save(); // Explicitly save the session

            return response()->json([
                'success' => true,
                'message' => 'Product moved to cart successfully!',
                'cart_count' => count($cart),
                'wishlist_count' => count($wishlist)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to move product to cart!'
            ], 500);
        }
    }

    public function moveAllToCart()
    {
        try {
            $wishlist = Session::get('wishlist', []);
            $cart = Session::get('cart', []);

            foreach ($wishlist as $productId => $item) {
                if (!isset($cart[$productId])) {
                    $cart[$productId] = $item;
                    $cart[$productId]['quantity'] = 1;
                }
            }

            Session::put('cart', $cart);
            Session::put('wishlist', []); // Clear wishlist
            Session::save(); // Explicitly save the session

            return response()->json([
                'success' => true,
                'message' => 'All products moved to cart successfully!',
                'cart_count' => count($cart),
                'wishlist_count' => 0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to move products to cart!'
            ], 500);
        }
    }
}
