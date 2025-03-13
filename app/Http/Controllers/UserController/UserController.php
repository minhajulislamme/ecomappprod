<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{
    public function UserDashboard()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        
        return view('frontend.dashboard.userdashboard', compact('user'));
    }
    public function UserLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        

        $notification = array(
            'message' => 'Successfully Logged Out',
            'alert-type' => 'success'  // 'success' or 'error' only
        );

        return redirect('/login')->with($notification);
    }

    public function UserProfileUpdate(Request $request)
    { 
        // Validate the image file
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg,gif|max:5120' // 5120KB = 5MB
            ], [
                'photo.max' => 'Photo size should not be greater than 5MB',
                'photo.mimes' => 'Photo must be of type: jpeg, png, jpg, gif'
            ]);
        }

        $id = Auth::user()->id;
        $user = User::find($id);
        $user->username = $request->username;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address = $request->address;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            // Create directory if doesn't exist
            $uploadPath = public_path('upload/user_images');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Delete old image if exists
            if ($user->photo) {
                $oldImage = $uploadPath . '/' . $user->photo;
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            // Generate unique filename
            $filename = date('YmdHi') . uniqid() . '.webp';

            // Create image manager instance
            $manager = new ImageManager(new Driver());

            // Process and save the image
            $image = $manager->read($file);
            $image->resize(800, 800) // Fixed size 800x800
                ->toWebp(70)  // Convert to WebP with 70% quality
                ->save($uploadPath . '/' . $filename);

            $user->photo = $filename;
        }

        $user->save();

        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function UserPasswordUpdate(Request $request)
    {
        try {
            // Validate Request
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|min:8',
                'new_password_confirmation' => 'required|same:new_password'
            ], [
                'old_password.required' => 'Old password is required',
                'new_password.required' => 'New password is required',
                'new_password.min' => 'New password must be at least 8 characters',
                'new_password_confirmation.same' => 'Password confirmation does not match'
            ]);

            // Match old password
            if (!Hash::check($request->old_password, auth()->user()->password)) {
                $notification = array(
                    'message' => 'Old Password Does Not Match!',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }

            // Confirm passwords match
            if ($request->new_password !== $request->new_password_confirmation) {
                $notification = array(
                    'message' => 'New Password And Confirmation Password Does Not Match!',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }

            // Update password
            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            $notification = array(
                'message' => 'Password Changed Successfully',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }
}
