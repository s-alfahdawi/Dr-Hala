<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SurgeriesPerHospitalChart extends ChartWidget
{
    protected static ?string $heading = 'عدد العمليات حسب المستشفى';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = DB::table('surgeries')
            ->join('hospitals', 'hospitals.id', '=', 'surgeries.hospital_id')
            ->selectRaw('hospitals.name as hospital, COUNT(surgeries.id) as total')
            ->groupBy('hospitals.name')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'عدد العمليات',
                    'data' => $data->pluck('total'),
                ],
            ],
            'labels' => $data->map(fn ($item) => "{$item->hospital} ({$item->total})"),
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
                    'display' => false,
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
            ],
            'scales' => [
                'x' => [
                    'ticks' => [
                        'autoSkip' => false,
                        'maxRotation' => 45,
                        'minRotation' => 45,
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}