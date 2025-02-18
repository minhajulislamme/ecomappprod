<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.index');
    }

    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'Successfully Logged Out',
            'alert-type' => 'success'
        );

        return redirect('/admin/login')->with($notification);
    }

    public function AdminLogin()
    {
        return view('admin.admin_login');
    }

    public function AdminLoginStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email format',
            'password.required' => 'Password is required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $notification = array(
                'message' => 'Successfully logged in',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.dashboard')->with($notification);
        } else {
            $notification = array(
                'message' => 'Invalid email or password',
                'alert-type' => 'error'
            );
            return redirect()->route('admin.login')->with($notification);
        }
    }

    public function AdminProfile()
    {
        $id = Auth::id();
        $adminData = User::find($id);
        return view('admin.profile.admin_profile', compact('adminData'));
    }

    public function AdminProfileUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $adminData = User::find($id);
        $adminData->name = $request->name;
        $adminData->email = $request->email;
        $adminData->phone = $request->phone;
        $adminData->address = $request->address;
        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/' . $adminData->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $adminData['photo'] = $filename;
        }
        $adminData->save();
        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success'  // only 'success' or 'error' supported by default
        );
        return redirect()->back()->with($notification);
    }
}
