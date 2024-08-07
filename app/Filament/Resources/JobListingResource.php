<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobListingResource\Pages;
use App\Filament\Resources\JobListingResource\RelationManagers;
use App\Models\JobListing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
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
                    ->label("Posted By")
                    ->relationship('user', 'firstName')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('jobTitle')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('jobDescription')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jobCategory.categoryName')
                    ->sortable(),
                Tables\Columns\TextColumn::make('recordStatus.status')
                    ->badge()
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
                SelectFilter::make("Status")
                    ->multiple()
                    ->relationship('recordStatus', 'status')
                    ->preload()
                    ->searchable(),

                SelectFilter::make("Job Category")
                    ->multiple()
                    ->relationship('jobCategory', 'categoryName')
                    ->preload()
                    ->searchable(),

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
            'index' => Pages\ListJobListings::route('/'),
            'create' => Pages\CreateJobListing::route('/create'),
            'edit' => Pages\EditJobListing::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'User Profile Attributes';
    }
}
