<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Str;

class FollowupsRelationManager extends RelationManager
{
    protected static string $relationship = 'followups';

    protected static ?string $title = 'المتابعات';
    protected static ?string $modelLabel = 'متابعة';
    protected static ?string $pluralModelLabel = 'المتابعات';

    public function table(Table $table): Table
    {
        return $table
        ->paginated()
        ->poll('30000')
        ->emptyStateHeading('لا توجد سجلات مرتبطة')
        ->emptyStateDescription('لم يتم إضافة بيانات مرتبطة بعد.')
        ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('surgery.surgeryType.name')->label('نوع العملية'),
                Tables\Columns\TextColumn::make('followup_date')->label('تاريخ المتابعة')->date(),
                Tables\Columns\TextColumn::make('type')->label('نوع المتابعة'),
                Tables\Columns\IconColumn::make('completed')->boolean()->label('تمت'),
            ])
            ->actions([
                Tables\Actions\Action::make('sendWhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->label('ارسال')
                    ->color('success')
                    ->url(fn ($record) => route('followups.send', $record))
                    ->openUrlInNewTab()
                    ->requiresConfirmation()
                    ->visible(fn ($record) => ! $record->completed),
            ]);
    }
}