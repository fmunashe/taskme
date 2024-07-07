<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestRegistrations extends BaseWidget
{
//    public function table(Table $table): Table
//    {
//        return $table
//            ->query(
//                // ...
//                fn (Builder $query) => $query->where('is_featured', true)
//            )
//            ->columns([
//                // ...
//            ]);
//
//        return $table
//            ->columns([
//                TextColumn::make('title'),
//                TextColumn::make('slug'),
//                IconColumn::make('is_featured')
//                    ->boolean(),
//            ]);
//    }

    protected static ?string $heading = 'Latest Registrations';

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return User::query()->latest()->limit(10);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('firstName')
                ->label('Name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Registered At')
                ->dateTime()
                ->sortable(),
        ];
    }
}
