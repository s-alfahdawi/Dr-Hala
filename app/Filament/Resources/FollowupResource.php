<?php

namespace App\Filament\Resources;

use App\Models\Followup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Route;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use App\Filament\Resources\FollowupResource\Pages;

class FollowupResource extends Resource
{
    protected static ?string $model = Followup::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('patient_id')
                ->label('المريضة')
                ->relationship('patient', 'name')
                ->searchable()
                ->required(),

            Select::make('surgery_id')
                ->label('العملية')
                ->relationship('surgery', 'display_name')
                ->searchable()
                ->required(),

            Select::make('followup_template_id')
                ->label('نوع المتابعة')
                ->relationship('followupTemplate', 'name')
                ->searchable()
                ->required(),

            DatePicker::make('followup_date')
                ->label('تاريخ المتابعة')
                ->required(),

            Toggle::make('completed')
                ->label('تمت؟'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.name')->label('المريضة')->searchable()->sortable(),
                TextColumn::make('surgery.display_name')->label('العملية')->sortable(),
                TextColumn::make('followup_date')->date()->label('تاريخ المتابعة')->sortable(),
                TextColumn::make('followupTemplate.name')->label('نوع المتابعة')->sortable(),
                BooleanColumn::make('completed')->label('تمت؟')->sortable(),
            ])
            ->defaultSort('followup_date', 'desc') // ✅ ترتيب مبدئي فقط
            ->filters([
                Tables\Filters\SelectFilter::make('surgery_type_id')
                    ->label('نوع العملية')
                    ->relationship('surgery.surgeryType', 'name'),
    
                Tables\Filters\SelectFilter::make('followup_template_id')
                    ->label('نوع المتابعة')
                    ->relationship('followupTemplate', 'name'),
    
                Tables\Filters\Filter::make('surgery_date')
                    ->label('🔍 فلترة حسب تاريخ العملية')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('من تاريخ العملية'),
                        Forms\Components\DatePicker::make('to')->label('إلى تاريخ العملية'),
                    ])
                    ->query(fn ($query, array $data) => $query
                        ->when($data['from'], fn ($q) => $q->whereHas('surgery', fn ($sq) => $sq->whereDate('date_of_surgery', '>=', $data['from'])))
                        ->when($data['to'], fn ($q) => $q->whereHas('surgery', fn ($sq) => $sq->whereDate('date_of_surgery', '<=', $data['to'])))),
    
                Tables\Filters\Filter::make('followup_date')
                    ->label('📅 فلترة حسب تاريخ المتابعة')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('من تاريخ المتابعة'),
                        Forms\Components\DatePicker::make('to')->label('إلى تاريخ المتابعة'),
                    ])
                    ->query(fn ($query, array $data) => $query
                        ->when($data['from'], fn ($q) => $q->whereDate('followup_date', '>=', $data['from']))
                        ->when($data['to'], fn ($q) => $q->whereDate('followup_date', '<=', $data['to']))),
    
                Tables\Filters\TernaryFilter::make('today')
                    ->label('متابعات اليوم فقط')
                    ->trueLabel('نعم')
                    ->queries(
                        true: fn ($query) => $query->whereDate('followup_date', today()),
                        false: fn ($query) => $query->whereDate('followup_date', '!=', today()),
                    ),
    
                Tables\Filters\TernaryFilter::make('completed')
                    ->label('مكتملة')
                    ->trueLabel('نعم')
                    ->queries(
                        true: fn ($query) => $query->where('completed', true),
                        false: fn ($query) => $query->where('completed', false),
                    ),
            ])
            ->actions([
                Action::make('sendWhatsApp')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->label('WhatsApp')
                    ->color('success')
                    ->url(fn ($record) => route('followups.send', $record))
                    ->openUrlInNewTab()
                    ->requiresConfirmation()
                    ->visible(fn ($record) => ! $record->completed),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFollowups::route('/'),
            'create' => Pages\CreateFollowup::route('/create'),
            'edit' => Pages\EditFollowup::route('/{record}/edit'),
        ];
    }
}