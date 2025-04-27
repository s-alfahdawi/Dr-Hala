<?php

namespace App\Filament\Resources\SurgeryTypeResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class SurgeryRelationManager extends RelationManager
{
    protected static string $relationship = 'surgeries';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.name')->label('المريضة'),
                Tables\Columns\TextColumn::make('date_of_surgery')->label('تاريخ العملية')->date(),
                Tables\Columns\TextColumn::make('hospital.name')->label('المستشفى'),
            ])
            ->actions([])
            ->bulkActions([]);
    }
}