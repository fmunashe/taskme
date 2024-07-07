<?php

namespace App\Filament\Resources\NextOfKinResource\Pages;

use App\Filament\Resources\NextOfKinResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNextOfKin extends EditRecord
{
    protected static string $resource = NextOfKinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
