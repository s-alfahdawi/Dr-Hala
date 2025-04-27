<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Forms\Components\DatePicker;
use Carbon\Carbon;
use App\Console\Commands\SendDailyFollowupsTelegram;
use Illuminate\Console\Scheduling\Schedule;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ⬅️ هنا تضع DatePicker
        DatePicker::configureUsing(function (DatePicker $datePicker) {
            $datePicker->displayFormat('d/m/Y');
        });

        $this->app->booted(function () {
            $schedule = app(Schedule::class);
            $schedule->command(SendDailyFollowupsTelegram::class)
                ->dailyAt('13:00');
        });
    }
}