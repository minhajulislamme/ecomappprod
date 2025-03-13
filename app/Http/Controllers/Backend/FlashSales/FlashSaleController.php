<?php

namespace App\Http\Controllers\Backend\FlashSales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FlashSelasTimer;

class FlashSaleController extends Controller
{
    public function showFlashSaleTimer()
    {
        $timer = FlashSelasTimer::latest()->first();
        return view('admin.flashsale.show_flash_selas_timer', [
            'timer' => [$timer] // Wrap in array to maintain blade foreach compatibility
        ]);
    }

    public function editFlashSaleTimer()
    {
        $timer = FlashSelasTimer::first();
        return view('admin.flashsale.edit_flash_selas_timer', compact('timer'));
    }

    public function updateFlashSaleTimer(Request $request)
    {
        $timer = FlashSelasTimer::first();
        $timer->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status ? 'active' : 'inactive',  // Set default value if checkbox is unchecked
        ]);

        return redirect()->route('flash.sale.timer.show')
            ->with('success', 'Flash Sale Timer Updated Successfully');
    }
}
