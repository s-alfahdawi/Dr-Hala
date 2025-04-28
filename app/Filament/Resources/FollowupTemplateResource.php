<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FollowupTemplateResource\Pages;
use App\Filament\Resources\FollowupTemplateResource\RelationManagers;
use App\Models\FollowupTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class FollowupTemplateResource extends Resource
{
    protected static ?string $model = FollowupTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'إجراءات المتابعة';
    protected static ?string $modelLabel = 'إجراء متابعة';
    protected static ?string $pluralModelLabel = 'إجراءات المتابعة';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('نوع المتابعة')
                ->required(),
    
            TextInput::make('days_after_surgery')
                ->label('عدد الأيام بعد العملية')
                ->numeric()
                ->required(),
    
            Textarea::make('message')
                ->label('رسالة المتابعة')
                ->rows(3)
                ->required(),
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
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable(),
                Tables\Columns\TextColumn::make('days_after_surgery')->label('عدد الأيام'),
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
            'index' => Pages\ListFollowupTemplates::route('/'),
            'create' => Pages\CreateFollowupTemplate::route('/create'),
            'edit' => Pages\EditFollowupTemplate::route('/{record}/edit'),
        ];
    }
}
