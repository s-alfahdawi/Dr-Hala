<?php

namespace App\Filament\Resources\FollowupTemplateResource\Pages;

use App\Filament\Resources\FollowupTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFollowupTemplates extends ListRecords
{
    protected static string $resource = FollowupTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
