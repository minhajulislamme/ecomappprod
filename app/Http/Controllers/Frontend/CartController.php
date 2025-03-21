<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Coupon;
use App\Models\Setting;
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
            $attrs = is_array($request->attributes) ? $request->attributes : $request->attributes->all();
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

        // Create GTM data layer for add to cart event
        $gtmData = [
            'event' => 'add_to_cart',
            'ecommerce' => [
                'currency' => 'BDT',
                'value' => ($product->discount_price ?? $product->price) * $quantity,
                'items' => [[
                    'item_id' => $product->id,
                    'item_name' => $product->name,
                    'price' => $product->discount_price ?? $product->price,
                    'item_category' => $product->category->category_name ?? '',
                    'item_category2' => $product->subcategory->subcategory_name ?? '',
                    'quantity' => $quantity
                ]]
            ]
        ];

        // Add Facebook Pixel Event only if Pixel ID is set in settings
        $pixelEvent = null;
        if (Setting::getValue('facebook_pixel_id')) {
            $pixelEvent = "fbq('track', 'AddToCart', {
                content_name: '" . addslashes($product->name) . "',
                content_ids: ['" . $product->id . "'],
                content_type: 'product',
                value: " . ($product->discount_price ?? $product->price) . ",
                currency: 'BDT',
                contents: [{
                    id: '" . $product->id . "',
                    quantity: " . $quantity . "
                }]
            });";
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => count($cart),
            'cart' => $cart,
            'pixelEvent' => $pixelEvent,
            'gtmData' => $gtmData
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
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);

            // Calculate subtotal and check for free shipping
            $subtotal = 0;
            $hasOnlyFreeShipping = true;

            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
                if (!isset($item['free_shipping']) || $item['free_shipping'] !== true) {
                    $hasOnlyFreeShipping = false;
                }
            }

            $itemTotal = $cart[$request->product_id]['price'] * $request->quantity;

            // Calculate discount if coupon exists
            $discount = 0;
            if (Session::has('coupon')) {
                $coupon = Session::get('coupon');
                $discount = ($subtotal * $coupon['discount_percentage']) / 100;
            }

            // Get shipping charge only if not all items have free shipping
            $shippingAmount = 0;
            if (!$hasOnlyFreeShipping) {
                $shippingCharge = \App\Models\ShippingCharge::where('status', 'active')->first();
                $shippingAmount = $shippingCharge ? $shippingCharge->charge : 0;
            }

            // Calculate total
            $total = $subtotal - $discount + $shippingAmount;

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully!',
                'item_total' => $itemTotal,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_charge' => $shippingAmount,
                'total' => $total,
                'has_only_free_shipping' => $hasOnlyFreeShipping
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart!'
        ], 404);
    }

    public function removeFromCart(Request $request)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$request->product_id])) {
            // Store item details before removal for response
            $removedItem = $cart[$request->product_id];

            // Remove the item
            unset($cart[$request->product_id]);
            Session::put('cart', $cart);

            // Calculate updated totals and check for free shipping
            $subtotal = 0;
            $hasOnlyFreeShipping = true;

            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
                if (!isset($item['free_shipping']) || $item['free_shipping'] !== true) {
                    $hasOnlyFreeShipping = false;
                }
            }

            // Get shipping charge only if not all items have free shipping
            $shippingAmount = 0;
            if (!$hasOnlyFreeShipping && count($cart) > 0) {
                $shippingCharge = \App\Models\ShippingCharge::where('status', 'active')->first();
                $shippingAmount = $shippingCharge ? $shippingCharge->charge : 0;
            }

            // Calculate discount if coupon exists
            $discount = 0;
            $couponCode = '';
            if (Session::has('coupon')) {
                $couponCode = Session::get('coupon')['code'];
                $coupon = Coupon::where('coupon_name', $couponCode)
                    ->where('status', 'active')
                    ->first();

                if ($coupon) {
                    $discount = ($subtotal * $coupon->coupon_discount) / 100;
                    Session::put('coupon', [
                        'code' => $couponCode,
                        'discount' => $discount,
                        'subtotal' => $subtotal,
                        'new_total' => $subtotal - $discount + $shippingAmount,
                        'discount_percentage' => $coupon->coupon_discount
                    ]);
                }
            }

            // If cart is empty after removal, remove coupon
            if (count($cart) === 0) {
                Session::forget('coupon');
            }

            $total = $subtotal - $discount + $shippingAmount;

            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart successfully',
                'cart_count' => count($cart),
                'cart' => $cart,
                'removed_item' => [
                    'id' => $request->product_id,
                    'name' => $removedItem['name'],
                    'price' => $removedItem['price'],
                    'quantity' => $removedItem['quantity']
                ],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_charge' => $shippingAmount,
                'total' => $total,
                'empty' => count($cart) === 0,
                'has_only_free_shipping' => $hasOnlyFreeShipping
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ], 404);
    }

    public function viewCart()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        $Categories = Category::where('status', 'active')->latest()->get();
        $Subcategories = SubCategory::where('status', 'active')->latest()->get();
        $contentIds = [];
        $contents = [];
        $gtmItems = [];

        // Build cart data for tracking
        foreach ($cart as $key => $item) {
            if (!isset($item['quantity'])) {
                $cart[$key]['quantity'] = 1;
                Session::put('cart', $cart);
            }
            $total += $item['price'] * $cart[$key]['quantity'];

            // Collect data for pixel event
            $contentIds[] = $item['id'];
            $contents[] = [
                'id' => $item['id'],
                'quantity' => $cart[$key]['quantity']
            ];

            // Build GTM item data
            $gtmItems[] = [
                'item_id' => $item['id'],
                'item_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $cart[$key]['quantity']
            ];
        }

        // Add GTM view_cart event
        $gtmData = [
            'event' => 'view_cart',
            'ecommerce' => [
                'currency' => 'BDT',
                'value' => $total,
                'items' => $gtmItems
            ]
        ];

        // Add Facebook Pixel Event for ViewCart only if Pixel ID is set in settings
        $pixelEvent = null;
        if (Setting::getValue('facebook_pixel_id')) {
            $pixelEvent = "fbq('track', 'ViewCart', {
                content_ids: " . json_encode($contentIds) . ",
                content_type: 'product',
                value: " . $total . ",
                currency: 'BDT',
                contents: " . json_encode($contents) . "
            });";
        }

        return view('frontend.cart.view_cart', compact('cart', 'total', 'Categories', 'Subcategories', 'pixelEvent', 'gtmData'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        // Get coupon from database
        $coupon = Coupon::where('coupon_name', $request->coupon_code)
            ->where('status', 'active')
            ->first();

        // Check if coupon exists and is valid
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code.'
            ]);
        }

        // Check if coupon is expired
        if ($coupon->coupon_validity && Carbon::now()->greaterThan(Carbon::parse($coupon->coupon_validity))) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon has expired.'
            ]);
        }

        $cart = Session::get('cart', []);
        $subtotal = 0;
        $hasOnlyFreeShipping = true;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            if (!isset($item['free_shipping']) || $item['free_shipping'] !== true) {
                $hasOnlyFreeShipping = false;
            }
        }

        // Calculate discount based on coupon percentage
        $discount = ($subtotal * $coupon->coupon_discount) / 100;

        // Get shipping charge only if not all items have free shipping
        $shippingAmount = 0;
        if (!$hasOnlyFreeShipping) {
            $shippingCharge = \App\Models\ShippingCharge::where('status', 'active')->first();
            $shippingAmount = $shippingCharge ? $shippingCharge->charge : 0;
        }

        $newTotal = $subtotal - $discount + $shippingAmount;

        // Store coupon info in session
        Session::put('coupon', [
            'code' => $coupon->coupon_name,
            'discount' => $discount,
            'subtotal' => $subtotal,
            'new_total' => $newTotal,
            'discount_percentage' => $coupon->coupon_discount
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon ' . $coupon->coupon_name . ' applied successfully! (' . $coupon->coupon_discount . '% off)',
            'discount' => $discount,
            'new_total' => $newTotal,
            'shipping_charge' => $shippingAmount,
            'has_only_free_shipping' => $hasOnlyFreeShipping
        ]);
    }

    public function removeCoupon()
    {
        Session::forget('coupon');

        $cart = Session::get('cart', []);
        $total = 0;
        $hasOnlyFreeShipping = true;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            if (!isset($item['free_shipping']) || $item['free_shipping'] !== true) {
                $hasOnlyFreeShipping = false;
            }
        }

        // Get shipping charge only if not all items have free shipping
        $shippingAmount = 0;
        if (!$hasOnlyFreeShipping) {
            $shippingCharge = \App\Models\ShippingCharge::where('status', 'active')->first();
            $shippingAmount = $shippingCharge ? $shippingCharge->charge : 0;
        }

        $total += $shippingAmount;

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed successfully!',
            'new_total' => $total,
            'shipping_charge' => $shippingAmount,
            'has_only_free_shipping' => $hasOnlyFreeShipping
        ]);
    }
}
