<?php

namespace App\Http\Controllers\Backend\Slider;

use App\Http\Controllers\Controller;
use App\Models\MainSlider;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SliderController extends Controller
{
    public function AllSlider()
    {
        $sliders = MainSlider::latest()->get();
        return view('admin.slider.all_slider', compact('sliders'));
    } //end method

    public function SliderAdd()
    {
        return view('admin.slider.add_slider');
    } //end method

    public function SliderStore(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:main_sliders|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $save_url = 'upload/slider/' . $name_gen;

            // Create directory if it doesn't exist
            if (!file_exists(public_path('upload/slider'))) {
                mkdir(public_path('upload/slider'), 0755, true);
            }

            // Initialize Intervention Image with GD driver
            $manager = new ImageManager(new Driver());

            // Load, resize and save the image
            $manager->read($image)
                ->resize(1920, 720, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save(public_path($save_url), 80);

            MainSlider::create([
                'title' => $request->title,
                'link' => $request->link,
                'image' => $save_url,
                'status' => 'active',
            ]);

            $notification = [
                'message' => 'Slider Added Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('all.slider')->with($notification);
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Error: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];

            return back()->with($notification)->withInput();
        }
    } //end method

    public function SliderEdit($id)
    {
        $slider = MainSlider::findOrFail($id);
        return view('admin.slider.edit_slider', compact('slider'));
    } //end method

    public function SliderUpdate(Request $request, $id)
    {
        $slider = MainSlider::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255|unique:main_sliders,title,' . $id,
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            if ($request->hasFile('image')) {
                // Delete old image
                if (file_exists(public_path($slider->image))) {
                    unlink(public_path($slider->image));
                }

                $image = $request->file('image');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $save_url = 'upload/slider/' . $name_gen;

                // Initialize Intervention Image with GD driver
                $manager = new ImageManager(new Driver());

                // Load, resize and save the image
                $manager->read($image)
                    ->resize(1920, 720, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->save(public_path($save_url), 80);

                $slider->image = $save_url;
            }

            $slider->title = $request->title;
            $slider->link = $request->link;
            $slider->status = $request->status;
            $slider->save();

            $notification = [
                'message' => 'Slider Updated Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('all.slider')->with($notification);
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Error: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];

            return back()->with($notification)->withInput();
        }
    } //end method

    public function SliderDelete($id)
    {
        $slider = MainSlider::findOrFail($id);

        // Delete image
        if (file_exists(public_path($slider->image))) {
            unlink(public_path($slider->image));
        }

        $slider->delete();

        $notification = [
            'message' => 'Slider Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.slider')->with($notification);
    } //end method

}
