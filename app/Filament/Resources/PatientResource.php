<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('name')
                ->required()
                ->regex('/^[\p{Arabic}a-zA-Z\s]+$/u')
                ->label('اسم المريضة'),
                
                TextInput::make('phone')
                    ->label('رقم الهاتف')
                    ->required()
                    ->regex('/^7[0-9]{9}$/')
                    ->unique('patients', 'phone', ignoreRecord: true)
                    ->helperText('رقم الهاتف يجب أن يبدأ بـ 7 ويتكون من 10 أرقام')
                    ->placeholder('771 391 1909'),

            Textarea::make('notes') // ✅ حقل الملاحظات
                ->label('ملاحظات')
                ->nullable(), // ❌ ليس مطلوب
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')->label('رقم الهاتف')->searchable(),
                Tables\Columns\TextColumn::make('surgeries_count')
                ->label('عدد العمليات')
                ->counts('surgeries')
                ->sortable(),
            ])
            ->filters([
                // ✅ فلتر تاريخ إنشاء المريضة
                Tables\Filters\Filter::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('من'),
                        Forms\Components\DatePicker::make('to')->label('إلى'),
                    ])
                    ->query(fn ($query, $data) => $query
                        ->when($data['from'], fn ($q) => $q->whereDate('created_at', '>=', $data['from']))
                        ->when($data['to'], fn ($q) => $q->whereDate('created_at', '<=', $data['to']))
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('sendWhatsApp')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->label('WhatsApp')
        ->color('success')
        ->icon('heroicon-o-chat-bubble-left')
        ->url(fn ($record) => 'https://wa.me/' . '964' . $record->phone . '?text=' . urlencode(
            "مرحبا حبيبتنا " . explode(' ', $record->name)[0] . ",\n\nوياج فريق عيادة الدكتورة حلا التميمي"
        ))
        ->openUrlInNewTab()
        ->requiresConfirmation()
        ->visible(fn ($record) => !empty($record->phone)),
])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc') // ترتيب افتراضي حسب الإضافة
            ->paginated();
    }

    public static function getRelations(): array
{
    return [
        \App\Filament\Resources\PatientResource\RelationManagers\SurgeriesRelationManager::class,
        \App\Filament\Resources\PatientResource\RelationManagers\FollowupsRelationManager::class,
    ];
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
