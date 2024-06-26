<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserProfileResource\Pages;
use App\Filament\Resources\UserProfileResource\RelationManagers;
use App\Models\UserProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserProfileResource extends Resource
{
    protected static ?string $model = UserProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'firstName')
                    ->required(),
                Forms\Components\DatePicker::make('dob'),
                Forms\Components\TextInput::make('idNumber')
                    ->maxLength(255),
                Forms\Components\TextInput::make('profession')
                    ->maxLength(255),
                Forms\Components\TextInput::make('highestEductionQualification'),
                Forms\Components\TextInput::make('bio'),
                Forms\Components\Select::make('maritalStatus')
                    ->searchable()
                    ->preload()
                    ->options([
                        'Married', 'Single', 'Widow', 'Widower'
                    ]),
                Forms\Components\Select::make('gender')
                    ->searchable()
                    ->preload()
                    ->options([
                        'Male', 'Female'
                    ]),
                Forms\Components\TextInput::make('religion')
                    ->maxLength(255),
                Forms\Components\TextInput::make('address'),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.firstName')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dob')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('idNumber')
                    ->searchable(),
                Tables\Columns\TextColumn::make('profession')
                    ->searchable(),
                Tables\Columns\TextColumn::make('highestEductionQualification'),
                Tables\Columns\TextColumn::make('maritalStatus'),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('religion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
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
            RelationManagers\UserRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserProfiles::route('/'),
            'create' => Pages\CreateUserProfile::route('/create'),
            'edit' => Pages\EditUserProfile::route('/{record}/edit'),
        ];
    }
}
