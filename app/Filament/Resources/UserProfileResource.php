<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserProfileResource\Pages;
use App\Filament\Resources\UserProfileResource\RelationManagers;
use App\Models\UserProfile;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Laravel\Prompts\TextareaPrompt;

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
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\DatePicker::make('dob'),
                Forms\Components\TextInput::make('idNumber')
                    ->maxLength(255),
                Forms\Components\TextInput::make('profession')
                    ->maxLength(255),
                Forms\Components\TextInput::make('highestEductionQualification'),
                Forms\Components\Select::make('maritalStatus')
                    ->searchable()
                    ->preload()
                    ->options([
                        'Married'=>'Married', 'Single'=>'Single', 'Widow'=>'Widow', 'Widower'=>'Widower'
                    ]),
                Forms\Components\Select::make('gender')
                    ->searchable()
                    ->preload()
                    ->options([
                        'Male'=>'Male', 'Female'=>'Female'
                    ]),
                Forms\Components\TextInput::make('religion')
                    ->maxLength(255),
                Forms\Components\TextInput::make('address'),
                Forms\Components\Select::make('status')
                    ->options(['Active'=>'Active','Inactive'=>'Inactive','Pending Review'=>'Pending Review'])
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\RichEditor::make('bio')
                ->columnSpanFull(),

                Forms\Components\Repeater::make('Health Conditions')
                    ->relationship('healthConditions')
                    ->schema([
                        TextInput::make('conditionName'),
                        TextInput::make('description'),
                    ])->columns(2)->columnSpanFull(),

                Forms\Components\Repeater::make('Next of Kin Details')
                    ->relationship('relatives')
                    ->schema([
                        TextInput::make('name'),
                        TextInput::make('mobile'),
                        TextInput::make('relationship'),
                        TextInput::make('address'),
                    ])->columns(2)->columnSpanFull(),
            ])->columns(2);
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
                Tables\Columns\TextColumn::make('maritalStatus')
                ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('gender')
                ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getNavigationGroup(): ?string
    {
        return 'User Management';
    }
    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-users';
    }
}
