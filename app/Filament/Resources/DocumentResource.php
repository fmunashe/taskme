<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Filament\Resources\DocumentResource\RelationManagers;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_profile_id')
                    ->relationship('userProfile', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => $record->user->firstName . ' ' . $record->user->lastName)
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('document_type_id')
                    ->relationship('documentType', 'documentType')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\FileUpload::make('name')
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
//                Forms\Components\TextInput::make('documentPath')
//                    ->required()
//                    ->maxLength(255),
                Forms\Components\Toggle::make('verified')
                    ->onColor('primary')
                    ->offColor('danger')
                    ->required(),
            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('userProfile.user.firstName')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('documentType.documentType')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('documentPath')
                    ->searchable(),
                Tables\Columns\IconColumn::make('verified')
                    ->boolean(),
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
                SelectFilter::make('Document Type')
                    ->multiple()
                    ->options([
                        'CV' => 'CV',
                        'Passport' => 'Passport',
                        'National ID' => 'National ID',
                        'Proof of Residence' => 'Proof of Residence',
                        'Police Clearance' => 'Police Clearance',
                    ])
                ->relationship('documentType','documentType')
                ->preload()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'User Profile Attributes';
    }
}
