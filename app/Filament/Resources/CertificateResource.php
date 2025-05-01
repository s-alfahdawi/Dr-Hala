<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateResource\Pages;
use App\Models\Certificate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'الشهادات';
    protected static ?string $modelLabel = 'شهادة';
    protected static ?string $pluralModelLabel = 'الشهادات';
    protected static ?string $navigationGroup = 'إدارة المحتوى';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->label('العنوان')
                ->required(),
    
            TextInput::make('specialty')
                ->label('الاختصاص')
                ->required(),
    
            TextInput::make('year_obtained')
                ->label('سنة الحصول')
                ->required()
                ->numeric(),
    
            FileUpload::make('image')
                ->label('الصورة')
                ->image()
                ->directory('certificates')
                ->previewable() // ✅ هذا يعرض الصورة الحالية
                ->disk('public')
                ->visibility('public')
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated()
            ->poll('30s')
            ->striped()
            ->emptyStateHeading('لا توجد شهادات')
            ->emptyStateDescription('لم يتم إضافة أي شهادة بعد.')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('specialty')
                    ->label('الاختصاص')
                    ->searchable(),

                Tables\Columns\TextColumn::make('year_obtained')
                    ->label('سنة الحصول')
                    ->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit' => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }
}