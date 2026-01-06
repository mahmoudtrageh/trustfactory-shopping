<?php

use App\Jobs\SendDailySalesReport;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new SendDailySalesReport(Carbon::yesterday()))
    ->dailyAt('18:00')
    ->timezone(config('app.timezone'));
