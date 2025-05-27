<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule your custom command to run once daily at 08:00
Schedule::command('appointments:send-reminders')
    // ->everyMinute()
    ->dailyAt('08:00')
    ->timezone('Asia/Beirut');  // interpret the time in Beirut timezone :contentReference[oaicite:0]{index=0}
