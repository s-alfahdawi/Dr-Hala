<?php

namespace App\Providers;
use App\Models\Surgery;
use App\Observers\SurgeryObserver;
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
        Surgery::observe(SurgeryObserver::class);

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