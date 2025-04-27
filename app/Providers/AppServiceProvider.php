<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Forms\Components\DatePicker;
use Carbon\Carbon;
use App\Console\Commands\SendDailyFollowupsTelegram;
use Illuminate\Console\Scheduling\Schedule;

DatePicker::configureUsing(function (DatePicker $datePicker) {
    $datePicker->displayFormat('d/m/Y');
});
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    
    public function boot(): void
    {
        $this->app->booted(function () {
            $schedule = app(Schedule::class);
            $schedule->command(SendDailyFollowupsTelegram::class)
                ->dailyAt('13:00');
        });
    }
}
