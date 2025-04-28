<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use App\Filament\Resources\SurgeryResource\Pages;
use App\Models\Surgery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SurgeryResource extends Resource
{
    protected static ?string $model = Surgery::class;

    protected static ?string $navigationIcon = 'heroicon-o-scissors';
    protected static ?string $navigationLabel = 'العمليات';
    protected static ?string $modelLabel = 'عملية';
    protected static ?string $pluralModelLabel = 'العمليات';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('patient_id')
                ->relationship('patient', 'name')
                ->searchable()
                ->label('اسم المريضة')
                ->required(),

            TextInput::make('age')
                ->numeric()
                ->label('عمر المريضة'),

            DatePicker::make('date_of_surgery')
                ->label('تاريخ العملية')
                ->required()
                ->after('1900-01-01')
                ->reactive(),

            Select::make('surgery_type_id')
                ->relationship('surgeryType', 'name')
                ->label('نوع العملية')
                ->required(),

            TextInput::make('child_name')
                ->label('اسم الطفل (إن وجد)'),

            Select::make('hospital_id')
                ->relationship('hospital', 'name')
                ->label('المستشفى')
                ->required(),

            Textarea::make('notes')
                ->label('ملاحظات إضافية')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated()
            ->poll('30s')
            ->emptyStateHeading('لا توجد سجلات متاحة')
            ->emptyStateDescription('لا يوجد بيانات حالياً، حاول إضافة سجل جديد.')
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('patient.name')
                    ->label('اسم المريضة')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('hospital.name')
                    ->label('المستشفى'),

                Tables\Columns\TextColumn::make('surgeryType.name')
                    ->label('نوع العملية'),

                Tables\Columns\TextColumn::make('date_of_surgery')
                    ->label('تاريخ العملية')
                    ->date(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('hospital_id')
                    ->label('المستشفى')
                    ->relationship('hospital', 'name'),

                Tables\Filters\SelectFilter::make('surgery_type_id')
                    ->label('نوع العملية')
                    ->relationship('surgeryType', 'name'),

                Tables\Filters\Filter::make('date_of_surgery')
                    ->label('تاريخ العملية')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('من تاريخ'),
                        Forms\Components\DatePicker::make('to')
                            ->label('إلى تاريخ'),
                    ])
                    ->query(function ($query, $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('date_of_surgery', '>=', $data['from']))
                            ->when($data['to'], fn ($q) => $q->whereDate('date_of_surgery', '<=', $data['to']));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('عرض'),

                Tables\Actions\EditAction::make()
                    ->label('تعديل'),

                Tables\Actions\DeleteAction::make()
                    ->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('حذف المحدد'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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