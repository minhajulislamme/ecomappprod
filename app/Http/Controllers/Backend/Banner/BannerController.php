<?php

namespace App\Http\Controllers\Backend\Banner;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BannerController extends Controller
{
    public function AllBanner()
    {
        $banners = Banner::latest()->get();
        return view('admin.banner.all_banner', compact('banners'));
    } //end method

    public function BannerAdd()
    {
        return view('admin.banner.add_banner');
    } //end method

    public function BannerStore(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:banners|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        try {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.webp';
            $save_url = 'upload/banner/' . $name_gen;

            // Create directory if it doesn't exist
            if (!file_exists(public_path('upload/banner'))) {
                mkdir(public_path('upload/banner'), 0755, true);
            }

            // Initialize Intervention Image with GD driver
            $manager = new ImageManager(new Driver());

            // Load, resize, optimize and save the image as WebP
            $manager->read($image)
                ->resize(800, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->toWebp(75)  // Convert to WebP with quality setting
                ->save(public_path($save_url));

            Banner::create([
                'title' => $request->title,
                'link' => $request->link,
                'image' => $save_url,
                'status' => 'active',
            ]);

            $notification = [
                'message' => 'Banner Added Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('all.banner')->with($notification);
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Error: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];

            return back()->with($notification)->withInput();
        }
    } //end method

    public function BannerEdit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit_banner', compact('banner'));
    } //end method

    public function BannerUpdate(Request $request)
    {
        $banner = Banner::findOrFail($request->id);

        $request->validate([
            'title' => 'required|max:255|unique:banners,title,' . $request->id,
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        try {
            if ($request->hasFile('image')) {
                // Delete old image
                if (file_exists(public_path($banner->image))) {
                    unlink(public_path($banner->image));
                }

                $image = $request->file('image');
                $name_gen = hexdec(uniqid()) . '.webp';
                $save_url = 'upload/banner/' . $name_gen;

                // Initialize Intervention Image with GD driver
                $manager = new ImageManager(new Driver());

                // Load, resize, optimize and save the image as WebP
                $manager->read($image)
                    ->resize(800, 300, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(75)  // Convert to WebP with quality setting
                    ->save(public_path($save_url));

                $banner->image = $save_url;
            }

            $banner->title = $request->title;
            $banner->link = $request->link;
            $banner->status = $request->status;
            $banner->save();

            $notification = [
                'message' => 'Banner Updated Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('all.banner')->with($notification);
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Error: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];

            return back()->with($notification)->withInput();
        }
    } //end method

    public function BannerDelete($id)
    {
        $banner = Banner::findOrFail($id);

        // Delete image
        if (file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }

        $banner->delete();

        $notification = [
            'message' => 'Banner Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    } //end method
}
