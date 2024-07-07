<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HealthConditionResource\Pages;
use App\Filament\Resources\HealthConditionResource\RelationManagers;
use App\Models\HealthCondition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HealthConditionResource extends Resource
{
    protected static ?string $model = HealthCondition::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_profile_id')
                    ->relationship('userProfile','id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => $record->user->firstName." ".$record->user->lastName )
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('conditionName')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('userProfile.user.firstName')
                    ->sortable(),
                Tables\Columns\TextColumn::make('conditionName')
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
//                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListHealthConditions::route('/'),
            'create' => Pages\CreateHealthCondition::route('/create'),
            'edit' => Pages\EditHealthCondition::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'User Profile Attributes';
    }
}
