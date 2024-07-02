<?php

namespace App\Filament\Resources\ConnectResource\Pages;

use App\Filament\Resources\ConnectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConnect extends EditRecord
{
    protected static string $resource = ConnectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
