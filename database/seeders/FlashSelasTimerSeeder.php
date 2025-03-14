<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FlashSelasTimer;

class FlashSelasTimerSeeder extends Seeder
{
    public function run(): void
    {
        FlashSelasTimer::create([
            'start_time' => now(),
            'end_time' => now()->addDays(7),
            'status' => 'active'
        ]);
    }
}
