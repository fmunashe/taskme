<?php

namespace App\Filament\Resources\NextOfKinResource\Pages;

use App\Filament\Resources\NextOfKinResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNextOfKin extends ListRecords
{
    protected static string $resource = NextOfKinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
