<?php

namespace App\Filament\Resources\RecordStatusResource\Pages;

use App\Filament\Resources\RecordStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecordStatuses extends ListRecords
{
    protected static string $resource = RecordStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
