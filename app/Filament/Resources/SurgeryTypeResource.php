<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use App\Filament\Resources\SurgeryTypeResource\Pages;
use App\Filament\Resources\SurgeryTypeResource\RelationManagers;
use App\Models\SurgeryType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
class SurgeryTypeResource extends Resource
{
    protected static ?string $model = SurgeryType::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'أنواع العمليات'; 
    protected static ?string $modelLabel = 'نوع عملية'; 
    protected static ?string $pluralModelLabel = 'أنواع العمليات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('اسم نوع العملية')->required(),
    
                Select::make('followupTemplates')
                    ->relationship('followupTemplates', 'name')
                    ->multiple()
                    ->label('أنواع المتابعات المطلوبة')
                    ->preload(),
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
                TextColumn::make('name')
                    ->label('اسم العملية')
                    ->sortable()
                    ->searchable(),
    
                TagsColumn::make('followupTemplates.name')
                    ->label('المتابعات المرتبطة')
                    ->separator(', '),
    
                TextColumn::make('surgeries_count')
                    ->label('عدد العمليات')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('followupTemplates')
                    ->label('نوع المتابعة')
                    ->relationship('followupTemplates', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

public static function getRelations(): array
{
    return [
    ];
}

public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->withCount('surgeries');
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurgeryTypes::route('/'),
            'create' => Pages\CreateSurgeryType::route('/create'),
            'edit' => Pages\EditSurgeryType::route('/{record}/edit'),
        ];
    }
}
