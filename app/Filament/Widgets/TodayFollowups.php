<?php

namespace App\Filament\Widgets;

use App\Models\Followup;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class TodayFollowups extends BaseWidget
{
    protected static ?string $heading = 'متابعات اليوم';

    protected function getTableQuery(): Builder
    {
        return Followup::with(['patient', 'followupTemplate'])
            ->whereDate('followup_date', today())
            ->where('completed', false);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('surgery.patient.name')->label('المريضة'),
            TextColumn::make('followup_date')->label('تاريخ المتابعة')->date(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('sendWhatsApp')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->label('ارسال')
                ->color('success')
                ->url(function ($record) {
                    $firstName = explode(' ', $record->patient->name)[0] ?? 'صديقتنا';
                    $phone = '964' . ltrim($record->patient->phone, '0');
                    $message = "مرحبا حبيبتنا {$firstName},\n\nوياج فريق عيادة الدكتورة حلا التميمي\n\n{$record->followupTemplate->message}";
                    return 'https://wa.me/' . $phone . '?text=' . urlencode($message);
                })
                ->openUrlInNewTab()
                ->requiresConfirmation(),
        ];
    }
}