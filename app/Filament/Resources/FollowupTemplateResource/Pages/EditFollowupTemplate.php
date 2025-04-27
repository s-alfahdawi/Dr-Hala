<?php

namespace App\Filament\Resources\FollowupTemplateResource\Pages;

use App\Filament\Resources\FollowupTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFollowupTemplate extends EditRecord
{
    protected static string $resource = FollowupTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
