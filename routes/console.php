<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('archive:clear')->dailyAt('02:00');
Schedule::command('tenants:auto-moveout')->dailyAt('00:05');

Schedule::command('bills:mark-overdue')->dailyAt('00:10');
Schedule::command('bills:notify-due-reminder')->dailyAt('09:00');
Schedule::command('reservations:notify-overdue')->dailyAt('08:00');
Schedule::command('tenants:notify-upcoming-moveouts')->dailyAt('08:05');