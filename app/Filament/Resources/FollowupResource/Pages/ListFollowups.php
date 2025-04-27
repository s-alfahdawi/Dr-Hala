<?php

namespace App\Filament\Resources\FollowupResource\Pages;
use Filament\Actions\Action;
use Illuminate\Support\Facades\URL;
use App\Filament\Resources\FollowupResource;
use Filament\Resources\Pages\ListRecords;

class ListFollowups extends ListRecords
{
    protected static string $resource = FollowupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('todayFollowups')
                ->label('متابعات اليوم 📅')
                ->color('success')
                ->icon('heroicon-o-calendar-days')
                ->url(URL::current() . '?tableFilters[today][value]=true')
        ];
    }
}