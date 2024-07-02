<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConnectResource\Pages;
use App\Filament\Resources\ConnectResource\RelationManagers;
use App\Models\Connect;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConnectResource extends Resource
{
    protected static ?string $model = Connect::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_profile_id')
                    ->relationship('userProfile','id')
                    ->label("User Profile")
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('totalConnects')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('userProfile.user.firstName')
                    ->label("User Profile")
                    ->sortable(),
                Tables\Columns\TextColumn::make('totalConnects')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListConnects::route('/'),
            'create' => Pages\CreateConnect::route('/create'),
            'edit' => Pages\EditConnect::route('/{record}/edit'),
        ];
    }
}
