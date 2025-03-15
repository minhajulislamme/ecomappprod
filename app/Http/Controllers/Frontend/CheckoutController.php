<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\ShippingCharge;
use App\Models\Product;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cart = Session::get('cart', []);

        if (count($cart) === 0) {
            return redirect()->route('shop');
        }

        $total = 0;
        $contentIds = [];
        $contents = [];
        $hasOnlyFreeShipping = true;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            $contentIds[] = $item['id'];
            $contents[] = [
                'id' => $item['id'],
                'quantity' => $item['quantity'],
                'item_price' => $item['price']
            ];
            if (!isset($item['free_shipping']) || !$item['free_shipping']) {
                $hasOnlyFreeShipping = false;
            }
        }

        // Add Facebook Pixel InitiateCheckout event only if pixel ID is set in settings
        $pixelEvent = null;
        if (Setting::getValue('facebook_pixel_id')) {
            $pixelEvent = "fbq('track', 'InitiateCheckout', {
                content_ids: " . json_encode($contentIds) . ",
                content_type: 'product',
                value: " . $total . ",
                currency: 'BDT',
                num_items: " . array_sum(array_column($cart, 'quantity')) . ",
                contents: " . json_encode($contents) . "
            });";
        }

        $shippingCharges = \App\Models\ShippingCharge::where('status', 'active')->get();

        return view('frontend.cart.checkout', compact('cart', 'total', 'shippingCharges', 'hasOnlyFreeShipping', 'pixelEvent'));
    }

    public function placeOrder(Request $request)
    {
        // Validate the request
        $validationRules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'payment_type' => 'required|in:online,cod'
        ];

        // Only require shipping_charge_id if not all items have free shipping
        $cart = Session::get('cart', []);
        $hasOnlyFreeShipping = true;
        foreach ($cart as $item) {
            if (!isset($item['free_shipping']) || $item['free_shipping'] !== true) {
                $hasOnlyFreeShipping = false;
                break;
            }
        }

        if (!$hasOnlyFreeShipping) {
            $validationRules['shipping_charge_id'] = 'required|exists:shipping_charges,id';
        }

        $request->validate($validationRules);

        // Check if cart is empty
        if (count($cart) == 0) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty',
                    'redirect' => route('shop')
                ]);
            }
            return redirect()->route('shop');
        }

        try {
            // Start database transaction
            return DB::transaction(function () use ($request, $cart, $hasOnlyFreeShipping) {
                // Calculate total
                $subtotal = 0;
                foreach ($cart as $item) {
                    $subtotal += $item['price'] * $item['quantity'];
                }

                // Get coupon discount if any
                $couponDiscount = 0;
                if (Session::has('coupon')) {
                    $couponDiscount = Session::get('coupon')['discount'];
                }

                // Get shipping charge
                $shippingCharge = 0;
                if (!$hasOnlyFreeShipping) {
                    $shippingCharge = ShippingCharge::findOrFail($request->shipping_charge_id)->charge;
                }

                // Calculate final amount
                $amount = $subtotal - $couponDiscount + $shippingCharge;

                // Generate order number and invoice
                $orderNumber = 'ORD-' . strtoupper(Str::random(10));
                $invoice = 'INV-' . strtoupper(Str::random(10));

                // Create order
                $order = new Orders();
                $order->user_id = Auth::check() ? Auth::id() : null;
                $order->name = $request->first_name . ' ' . $request->last_name;
                $order->email = $request->email;
                $order->phone = $request->phone;
                $order->address = $request->address;
                $order->city = $request->city;
                $order->postal_code = $request->postal_code;
                $order->payment_type = $request->payment_type;
                $order->payment_method = $request->payment_type == 'online' ? 'Card/Online' : 'Cash On Delivery';
                $order->transaction_id = $request->payment_type == 'online' ? 'Online Payment' : null;
                $order->currency = 'BDT';
                $order->amount = $amount;
                $order->coupon_discount = $couponDiscount > 0 ? $couponDiscount : null;
                $order->shipping_charge = $shippingCharge;
                $order->order_number = $orderNumber;
                $order->invoice_no = $invoice;
                $order->order_date = Carbon::now()->format('d F Y');
                $order->order_month = Carbon::now()->format('F');
                $order->order_year = Carbon::now()->year;
                $order->status = 'pending';
                $order->save();

                // Save order items and update product stock
                foreach ($cart as $key => $item) {
                    $orderItem = new OrderItems();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $item['id'];
                    $orderItem->quantity = $item['quantity'];
                    $orderItem->price = $item['price'];
                    $orderItem->thumbnail_image = $item['image'];

                    if (!empty($item['attributes'])) {
                        $orderItem->attribute_values = json_encode($item['attributes']);
                    }

                    $orderItem->save();

                    // Update product stock with lock to prevent race conditions
                    $product = Product::lockForUpdate()->find($item['id']);
                    if ($product) {
                        if ($product->stock < $item['quantity']) {
                            throw new \Exception('Insufficient stock for product: ' . $product->name);
                        }
                        $product->stock = max(0, $product->stock - $item['quantity']);
                        $product->save();
                    }
                }

                // Build address info for pixel tracking
                $addressInfo = [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code
                ];

                $contentIds = [];
                $contents = [];

                foreach ($cart as $item) {
                    $contentIds[] = $item['id'];
                    $contents[] = [
                        'id' => $item['id'],
                        'quantity' => $item['quantity']
                    ];
                }

                // Enhanced Facebook Pixel Event for Purchase with customer data (only if pixel ID is set in settings)
                $pixelEvent = null;
                if (Setting::getValue('facebook_pixel_id')) {
                    $pixelEvent = "fbq('track', 'Purchase', {
                        content_ids: " . json_encode($contentIds) . ",
                        contents: " . json_encode($contents) . ",
                        value: " . $order->amount . ",
                        currency: 'BDT',
                        num_items: " . array_sum(array_column($cart, 'quantity')) . ",
                        shipping_tier: '" . ($hasOnlyFreeShipping ? 'Free Shipping' : 'Standard Shipping') . "',
                        payment_type: '" . $request->payment_type . "',
                        customer_type: '" . (Auth::check() ? 'Registered' : 'Guest') . "'
                    });";
                }

                // Clear cart and coupon after successful order
                Session::forget(['cart', 'coupon']);

                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully',
                    'redirect' => route('checkout.success', ['order_number' => $order->order_number]),
                    'pixelEvent' => $pixelEvent
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order. ' . $e->getMessage(),
            ], 500);
        }
    }

    public function checkoutSuccess($orderNumber)
    {
        $order = Orders::with(['orderItems.product'])->where('order_number', $orderNumber)->firstOrFail();

        // Clear cart after successful order
        Session::forget('cart');
        Session::forget('coupon');

        return view('frontend.cart.checkout_success', compact('order'));
    }

    public function validateCheckoutForm(Request $request)
    {
        $validator = validator($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'shipping_charge_id' => 'required|exists:shipping_charges,id',
            'payment_type' => 'required|in:online,cod'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function directCheckout(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'attributes' => 'nullable|array'
            ]);

            $product = Product::findOrFail($request->product_id);

            // Validate product stock
            if ($product->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock for product: ' . $product->name
                ], 400);
            }

            $cartKey = (string)$request->product_id;

            // Only process attributes if they exist and are not empty
            if ($request->has('attributes') && !empty($request->attributes)) {
                $attrs = is_array($request->attributes) ? $request->attributes : $request->attributes->all();
                if (!empty($attrs)) {
                    ksort($attrs);
                    foreach ($attrs as $attrId => $attr) {
                        $cartKey .= '_' . $attrId . '_' . $attr['value'];
                    }
                }
            }

            // Create cart item
            $cart = [];
            $cart[$cartKey] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $request->quantity,
                'price' => $product->discount_price ?? $product->price,
                'image' => asset($product->thumbnail_image),
                'attributes' => $request->input('attributes', []),
                'free_shipping' => $product->free_shipping === 'yes'
            ];

            Session::put('cart', $cart);
            Session::forget('coupon');

            return response()->json([
                'success' => true,
                'message' => 'Product added for direct checkout.',
                'redirect' => route('checkout')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
