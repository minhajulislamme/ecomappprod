<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid request method'
                ], 400);
            }

            $productId = $request->input('product_id');
            if (!$productId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product ID is required'
                ], 400);
            }

            $quantity = max(1, intval($request->input('quantity', 1)));
            $attributes = $request->input('attributes', []);

            $product = Product::findOrFail($productId);

            // Check if product has attributes but none provided
            if ($product->hasConfiguredAttributes() && empty($attributes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please select product attributes',
                    'redirect' => route('product.details', ['id' => $productId, 'slug' => $product->slug])
                ], 400);
            }

            // Create cart key
            $cartKey = !empty($attributes) ? $productId . '_' . md5(json_encode($attributes)) : $productId;
            $cart = Session::get('cart', []);

            // Check if product already exists in cart
            if (isset($cart[$cartKey])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product already in cart'
                ], 400);
            }

            // Add new product to cart
            $price = $product->discount_price && $product->discount_price < $product->price
                ? $product->discount_price
                : $product->price;

            $cart[$cartKey] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $price,
                'quantity' => $quantity,
                'image' => asset($product->thumbnail_image),
                'attributes' => $attributes
            ];

            Session::put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => count($cart),
                'cart' => $cart
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Cart Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getCart()
    {
        $cart = Session::get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'total' => $total
        ]);
    }

    public function updateCart(Request $request)
    {
        try {
            $productId = $request->product_id;
            $quantity = $request->quantity;

            $cart = Session::get('cart', []);

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
                $itemTotal = $cart[$productId]['price'] * $quantity;

                Session::put('cart', $cart);

                $total = 0;
                foreach ($cart as $item) {
                    $total += $item['price'] * $item['quantity'];
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully!',
                    'item_total' => $itemTotal,
                    'total' => $total
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart!'
            ], 500);
        }
    }

    public function removeFromCart(Request $request)
    {
        try {
            $productId = $request->product_id;
            $cart = Session::get('cart', []);

            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                Session::put('cart', $cart);

                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from cart!',
                    'cart_count' => count($cart)
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove product from cart!'
            ], 500);
        }
    }

    public function viewCart()
    {
        $cart = Session::get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Fetch categories and subcategories for the layout
        $Categories = Category::where('status', 'active')->latest()->get();
        $Subcategories = SubCategory::where('status', 'active')->latest()->get();

        return view('frontend.cart.view_cart', compact('cart', 'total', 'Categories', 'Subcategories'));
    }

    public function clearCart()
    {
        Session::forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully!'
        ]);
    }
}
