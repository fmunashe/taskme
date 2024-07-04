<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;
    protected ?string $maxContentWidth = 'full';
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->askForFilename()
                        ->askForWriterType()
                        ->fromTable()
                        ->withColumns([
                            Column::make('created_at'),
                            Column::make('updated_at'),
                        ])
                ]),
        ];
    }
}
