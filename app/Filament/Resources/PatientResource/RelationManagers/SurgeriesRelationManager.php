<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SurgeriesRelationManager extends RelationManager
{
    protected static string $relationship = 'surgeries';

    protected static ?string $title = 'العمليات الجراحية'; // ✅ تعريب عنوان الجدول
    
    protected static ?string $pluralModelLabel = 'العمليات الجراحية'; // ✅ اسم الجمع
    
    protected static ?string $modelLabel = 'عملية جراحية'; // ✅ اسم المفرد

    public function table(Table $table): Table
    {
        return $table
        ->paginated()
        ->poll('30000')
        ->emptyStateHeading('لا توجد سجلات مرتبطة')
        ->emptyStateDescription('لم يتم إضافة بيانات مرتبطة بعد.')
        ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('date_of_surgery')->label('تاريخ العملية')->date(),
                Tables\Columns\TextColumn::make('surgeryType.name')->label('نوع العملية'),
                Tables\Columns\TextColumn::make('hospital.name')->label('المستشفى'),
            ])
            ->actions([])
            ->bulkActions([]);
    }
}