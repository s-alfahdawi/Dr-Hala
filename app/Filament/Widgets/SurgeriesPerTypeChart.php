<?php

// app/Filament/Widgets/SurgeriesPerTypeChart.php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SurgeriesPerTypeChart extends ChartWidget
{
    protected static ?string $heading = 'عدد العمليات حسب نوع العملية';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $data = DB::table('surgeries')
            ->join('surgery_types', 'surgery_types.id', '=', 'surgeries.surgery_type_id')
            ->selectRaw('surgery_types.name as type, COUNT(surgeries.id) as total')
            ->groupBy('surgery_types.name')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'عدد العمليات',
                    'data' => $data->pluck('total'),
                ],
            ],
            'labels' => $data->map(fn ($item) => "{$item->type} ({$item->total})"),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'plugins' => [
                'legend' => [
                    'display' => false, // Hide legend for cleaner look
                ],
                'tooltip' => [
                    'enabled' => true, // Show tooltips on hover
                ],
            ],
            'scales' => [
                'x' => [
                    'ticks' => [
                        'autoSkip' => false, // Show all labels
                        'maxRotation' => 45, // Rotate for better readability
                        'minRotation' => 45,
                    ],
                ],
                'y' => [
                    'beginAtZero' => true, // Ensure the scale starts at zero
                    'ticks' => [
                        'stepSize' => 1, // Ensure y-axis has integer steps
                    ],
                ],
            ],
        ];
    }
}