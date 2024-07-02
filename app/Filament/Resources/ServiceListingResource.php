<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceListingResource\Pages;
use App\Filament\Resources\ServiceListingResource\RelationManagers;
use App\Models\ServiceListing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceListingResource extends Resource
{
    protected static ?string $model = ServiceListing::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('service_category_id')
                    ->preload()
                    ->relationship('serviceCategory','categoryName')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->preload()
                    ->relationship('client','firstName')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('serviceName')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('serviceDescription')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('record_status_id')
                    ->preload()
                    ->relationship('recordStatus','id')
                    ->searchable()
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('serviceCategory.categoryName')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.firstName')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('recordStatus.status')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('serviceName')
                    ->searchable(),
                Tables\Columns\TextColumn::make('serviceDescription')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceListings::route('/'),
            'create' => Pages\CreateServiceListing::route('/create'),
            'edit' => Pages\EditServiceListing::route('/{record}/edit'),
        ];
    }
}
