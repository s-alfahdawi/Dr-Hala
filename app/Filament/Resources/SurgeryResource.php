<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use App\Filament\Resources\SurgeryResource\Pages;
use App\Filament\Resources\SurgeryResource\RelationManagers;
use App\Models\Surgery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SurgeryResource extends Resource
{
    protected static ?string $model = Surgery::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('patient_id')
                    ->relationship('patient', 'name')
                    ->searchable()
                    ->required(),
    
                TextInput::make('age')
                    ->numeric(),
    
                DatePicker::make('date_of_surgery')
                    ->required()
                    ->after('1900-01-01')
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => [
                        $set('followup_day_3', now()->parse($state)->addDays(3)->format('Y-m-d')),
                        $set('followup_day_9', now()->parse($state)->addDays(9)->format('Y-m-d')),
                        $set('followup_day_39', now()->parse($state)->addDays(39)->format('Y-m-d')),
                        $set('b_date', now()->parse($state)->addYear()->format('Y-m-d')),
                    ]),
    
                Select::make('surgery_type_id')
                    ->relationship('surgeryType', 'name')
                    ->required(),
    
                TextInput::make('child_name'),
    
                Select::make('hospital_id')
                    ->relationship('hospital', 'name')
                    ->required(),
    
                Textarea::make('notes')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.name')->label('المريضة')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('hospital.name')->label('المستشفى'),
                Tables\Columns\TextColumn::make('surgeryType.name')->label('نوع العملية'),
                Tables\Columns\TextColumn::make('date_of_surgery')->label('تاريخ العملية')->date(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('hospital_id')->label('المستشفى')->relationship('hospital', 'name'),
                Tables\Filters\SelectFilter::make('surgery_type_id')->label('نوع العملية')->relationship('surgeryType', 'name'),
                Tables\Filters\Filter::make('date_of_surgery')
                    ->label('التاريخ')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('to'),
                    ])
                    ->query(function ($query, $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('date_of_surgery', '>=', $data['from']))
                            ->when($data['to'], fn ($q) => $q->whereDate('date_of_surgery', '<=', $data['to']));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurgeries::route('/'),
            'create' => Pages\CreateSurgery::route('/create'),
            'edit' => Pages\EditSurgery::route('/{record}/edit'),
        ];
    }
}
