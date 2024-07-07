<?php

namespace App\Filament\Resources\HealthConditionResource\Pages;

use App\Filament\Resources\HealthConditionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHealthConditions extends ListRecords
{
    protected static string $resource = HealthConditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
