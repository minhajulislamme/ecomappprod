<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'attributes' => 'nullable|array'
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = Session::get('cart', []);

        // Set default quantity to 1 if not provided
        $quantity = $request->quantity ?? 1;

        // Generate unique cart key based on product ID and attributes
        $cartKey = $request->product_id;

        if ($request->has('attributes') && !empty($request->attributes)) {
            // Convert attributes to array and sort by key
            $attrs = $request->input('attributes');
            ksort($attrs);
            foreach ($attrs as $attrId => $attr) {
                $cartKey .= '_' . $attrId . '_' . $attr['value'];
            }
        }

        // Check if item already exists in cart with same attributes
        if (isset($cart[$cartKey])) {
            return response()->json([
                'success' => false,
                'message' => 'This item is already in your cart. You can update the quantity from the cart.',
                'cart_count' => count($cart),
                'cart' => $cart
            ], 400);
        }

        // Add new item to cart with free_shipping status
        $cart[$cartKey] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => $quantity,
            'price' => $product->discount_price ?? $product->price,
            'image' => asset($product->thumbnail_image),
            'attributes' => $request->input('attributes', []),
            'free_shipping' => $product->free_shipping === 'yes'
        ];

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => count($cart),
            'cart' => $cart
        ]);
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
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);

            $itemTotal = $cart[$request->product_id]['price'] * $request->quantity;
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
    }

    public function removeFromCart(Request $request)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
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
    }

    public function viewCart()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        $Categories = Category::where('status', 'active')->latest()->get();
        $Subcategories = SubCategory::where('status', 'active')->latest()->get();

        // Ensure each cart item has a quantity
        foreach ($cart as $key => $item) {
            // Set default quantity to 1 if not set
            if (!isset($item['quantity'])) {
                $cart[$key]['quantity'] = 1;
                Session::put('cart', $cart);
            }
            $total += $item['price'] * $cart[$key]['quantity'];
        }

        return view('frontend.cart.view_cart', compact('cart', 'total', 'Categories', 'Subcategories'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        // Only accept "MINHAZ" as valid coupon code with 25% discount
        if ($request->coupon_code !== 'MINHAZ') {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code.'
            ]);
        }

        $cart = Session::get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Fixed 25% discount
        $discount = ($subtotal * 25) / 100;
        $newTotal = $subtotal - $discount;

        // Store coupon info in session
        Session::put('coupon', [
            'code' => 'MINHAZ',
            'discount' => $discount,
            'subtotal' => $subtotal,
            'new_total' => $newTotal
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon MINHAZ applied successfully! (25% off)',
            'discount' => $discount,
            'new_total' => $newTotal
        ]);
    }

    public function removeCoupon()
    {
        Session::forget('coupon');

        $cart = Session::get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed successfully!',
            'new_total' => $total
        ]);
    }
}
