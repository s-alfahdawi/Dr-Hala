<?php

namespace App\Filament\Widgets;

use App\Models\Followup;
use Filament\Widgets\ChartWidget;

class FollowupCompletionChart extends ChartWidget
{
    protected static ?string $heading = 'عدد المتابعات حسب حالة الإكمال';
    protected static ?int $sort = 5; // تغيير الترتيب حسب الحاجة

    protected function getData(): array
    {
        $completed = Followup::where('completed', true)->count();
        $pending = Followup::where('completed', false)->count();

        return [
            'datasets' => [
                [
                    'label' => 'عدد المتابعات',
                    'data' => [$completed, $pending],
                    'backgroundColor' => ['#10B981', '#EF4444'], // أخضر للمكتملة، أحمر لغير المكتملة
                ],
            ],
            'labels' => ['مكتملة ✅', 'غير مكتملة ❌'],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // رسم بياني شريطي
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