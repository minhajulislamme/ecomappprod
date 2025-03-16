<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display the settings form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $settings = [
            'facebook_pixel_id' => Setting::getValue('facebook_pixel_id'),
            'google_tag_manager_id' => Setting::getValue('google_tag_manager_id')
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'facebook_pixel_id' => 'nullable|string|max:255',
            'google_tag_manager_id' => 'nullable|string|max:255'
        ]);

        // Update or create settings
        Setting::setValue(
            'facebook_pixel_id',
            $validated['facebook_pixel_id'],
            'Facebook Pixel ID for tracking'
        );

        Setting::setValue(
            'google_tag_manager_id',
            $validated['google_tag_manager_id'],
            'Google Tag Manager container ID'
        );

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully');
    }

    /**
     * Get Google Tag Manager ID.
     *
     * @return string|null
     */
    public static function getGTMId()
    {
        return Setting::getValue('google_tag_manager_id');
    }

    /**
     * Get Facebook Pixel ID.
     *
     * @return string|null
     */
    public static function getPixelId()
    {
        return Setting::getValue('facebook_pixel_id');
    }
}
