<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SurgeriesRelationManager extends RelationManager
{
    protected static string $relationship = 'surgeries';
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_of_surgery')->label('تاريخ العملية')->date(),
                Tables\Columns\TextColumn::make('surgeryType.name')->label('نوع العملية'),
                Tables\Columns\TextColumn::make('hospital.name')->label('المستشفى'),
            ])
            ->actions([])
            ->bulkActions([]);
    }
}