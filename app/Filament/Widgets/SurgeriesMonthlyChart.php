<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SurgeriesMonthlyChart extends ChartWidget
{
    protected static ?string $heading = 'عدد العمليات شهريًا';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = DB::table('surgeries')
            ->selectRaw('DATE_FORMAT(date_of_surgery, "%Y-%m") as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'عدد العمليات',
                    'data' => $data->pluck('total'),
                ],
            ],
            'labels' => $data->map(fn ($item) => "{$item->month} ({$item->total})"),
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