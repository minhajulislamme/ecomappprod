<?php

namespace App\Http\Controllers\Backend\Coupon;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function AllCoupon()
    {
        $Coupon = Coupon::latest()->get();
        return view('admin.coupon.all_coupon', compact('Coupon'));

    }// end method
    public function CouponAdd()
    {
        return view('admin.coupon.add_coupon');

    }// end method

    public function CouponStore(Request $request)
    {
        $request->validate([
            'coupon_name' => 'required',
            'coupon_discount' => 'required',
            'coupon_validity' => 'required',
        ]);

        Coupon::insert([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'status' => 'active',
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Coupon Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.coupon')->with($notification);

    }// end method
    public function CouponEdit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.edit_coupon', compact('coupon'));

    }// end method

    public function CouponUpdate(Request $request, $id)
    {
        $request->validate([
            'coupon_name' => 'required',
            'coupon_discount' => 'required',
            'coupon_validity' => 'required',
        ]);

        Coupon::findOrFail($id)->update([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'status' => $request->status === 'active' ? 'active' : 'inactive',
            'updated_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Coupon Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.coupon')->with($notification);

    }// end method
    public function CouponDelete($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        $notification = [
            'message' => 'Coupon Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.coupon')->with($notification);

    }// end method
}
