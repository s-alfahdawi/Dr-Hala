<?php

// app/Filament/Widgets/TotalStatsWidget.php
namespace App\Filament\Widgets;

use App\Models\Patient;
use App\Models\Surgery;
use App\Models\SurgeryType;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $topType = SurgeryType::withCount('surgeries')
            ->orderByDesc('surgeries_count')
            ->first()?->name ?? 'غير معروف';

        return [
            Stat::make('عدد المرضى', Patient::count()),
            Stat::make('عدد العمليات', Surgery::count()),
            Stat::make('المرضى المتكررين', Surgery::select('patient_id')->groupBy('patient_id')->havingRaw('COUNT(*) > 1')->count()),
            Stat::make('أكثر نوع عملية متكرر', $topType),
        ];
    }
}