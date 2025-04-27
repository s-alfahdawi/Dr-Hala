<?php

namespace App\Filament\Resources\SurgeryTypeResource\Pages;

use App\Filament\Resources\SurgeryTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSurgeryTypes extends ListRecords
{
    protected static string $resource = SurgeryTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
