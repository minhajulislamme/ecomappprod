<?php

namespace App\Http\Controllers\Backend\ShippingCharge;

use App\Http\Controllers\Controller;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;

class ShippingChargeController extends Controller
{
    public function AllShippingCharge()
    {
        $charges = ShippingCharge::latest()->get();
        return view('admin.shipping.all_shipping_charges', compact('charges'));
    }

    public function AddShippingCharge()
    {
        return view('admin.shipping.add_shipping_charge');
    }

    public function StoreShippingCharge(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'charge' => 'required|numeric|min:0',


        ]);

        ShippingCharge::insert([
            'name' => $validated['name'],
            'charge' => $validated['charge'],
            'status' => 'active',
        ]);
        $notification = [
            'message' => 'Shipping charge added successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('all.shipping.charges')
            ->with($notification);
    }

    public function EditShippingCharge($id)
    {
        $charge = ShippingCharge::findOrFail($id);
        return view('admin.shipping.edit_shipping_charge', compact('charge'));
    }

    public function UpdateShippingCharge(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'charge' => 'required|numeric|min:0',


        ]);

        ShippingCharge::findOrFail($id)->update([
            'name' => $validated['name'],
            'charge' => $validated['charge'],
            'status' => $request->status ? 'active' : 'inactive',
        ]);
        $notification = [
            'message' => 'Shipping charge updated successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('all.shipping.charges')
            ->with($notification);
    }

    public function DeleteShippingCharge($id)
    {
        $charge = ShippingCharge::findOrFail($id);
        $charge->delete();

        return redirect()
            ->route('all.shipping.charges')
            ->with(['message' => 'Shipping charge deleted successfully', 'alert-type' => 'success']);
    }
}
