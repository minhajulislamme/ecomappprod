<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\ShippingCharge;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cart = Session::get('cart', []);

        // Redirect to shop if cart is empty
        if (count($cart) == 0) {
            return redirect()->route('shop');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $shippingCharges = ShippingCharge::where('status', 'active')->get();

        return view('frontend.cart.checkout', compact('cart', 'total', 'shippingCharges'));
    }

    public function placeOrder(Request $request)
    {
        // Validate the request
        $request->validate([
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

        $cart = Session::get('cart', []);

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
            $shippingCharge = ShippingCharge::findOrFail($request->shipping_charge_id);

            // Calculate final amount
            $amount = $subtotal - $couponDiscount + $shippingCharge->charge;

            // Generate order number
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
            $order->shipping_charge = $shippingCharge->charge;
            $order->order_number = $orderNumber;
            $order->invoice_no = $invoice;
            $order->order_date = Carbon::now()->format('d F Y');
            $order->order_month = Carbon::now()->format('F');
            $order->order_year = Carbon::now()->year;
            $order->status = 'pending';
            $order->save();

            // Save order items
            foreach ($cart as $key => $item) {
                $orderItem = new OrderItems();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item['id'];
                $orderItem->quantity = $item['quantity'];
                $orderItem->price = $item['price'];
                $orderItem->thumbnail_image = $item['image'];

                // Check if there are attributes and save them
                if (!empty($item['attributes'])) {
                    $orderItem->attribute_values = json_encode($item['attributes']);
                }

                $orderItem->save();

                // Update product quantity
                $product = Product::find($item['id']);
                if ($product) {
                    $product->stock = max(0, ($product->stock ?? 0) - $item['quantity']);
                    $product->save();
                }
            }

            // Clear cart and coupon after successful order
            Session::forget(['cart', 'coupon']);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully',
                    'order' => $order,
                    'redirect' => route('checkout.success', ['order_number' => $order->order_number])
                ]);
            }

            return redirect()->route('checkout.success', ['order_number' => $order->order_number]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to place order. Please try again.',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to place order. Please try again.');
        }
    }

    public function checkoutSuccess($order_number)
    {
        $order = Orders::where('order_number', $order_number)->first();

        if (!$order) {
            return redirect()->route('home');
        }

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
}
