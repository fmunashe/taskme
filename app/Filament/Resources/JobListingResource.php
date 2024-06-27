<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobListingResource\Pages;
use App\Filament\Resources\JobListingResource\RelationManagers;
use App\Models\JobListing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobListingResource extends Resource
{
    protected static ?string $model = JobListing::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('job_category_id')
                    ->relationship('jobCategory', 'categoryName')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('record_status_id')
                    ->relationship('recordStatus', 'status')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'firstName')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('jobTitle')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('jobDescription')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jobCategory.categoryName')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('recordStatus.status')
                    ->colors([
                        'warning' => 'Pending Review',
                        'success' => 'Active',
                        'danger' => 'Inactive',
                    ]),
                Tables\Columns\TextColumn::make('user.firstName')
                    ->label("Posted By")
                    ->sortable(),
                Tables\Columns\TextColumn::make('jobTitle')
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
            'index' => Pages\ListJobListings::route('/'),
            'create' => Pages\CreateJobListing::route('/create'),
            'edit' => Pages\EditJobListing::route('/{record}/edit'),
        ];
    }
}
