<?php

namespace App\Filament\Resources\HealthConditionResource\Pages;

use App\Filament\Resources\HealthConditionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHealthCondition extends EditRecord
{
    protected static string $resource = HealthConditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
