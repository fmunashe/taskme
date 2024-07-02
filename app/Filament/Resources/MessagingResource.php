<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessagingResource\Pages;
use App\Filament\Resources\MessagingResource\RelationManagers;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MessagingResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sender_id')
                    ->label("Sender")
                    ->relationship('users', 'users.firstName')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('receiver_id')
                    ->label("Receiver")
                    ->relationship('users', 'users.firstName')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\RichEditor::make('message')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('readStatus')
                    ->label("Is Read?")
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
                Tables\Columns\TextColumn::make('users.firstName')
                    ->label('Sender')
                    ->sortable(),
                Tables\Columns\TextColumn::make('receiver.firstName')
                    ->label("Receiver")
                    ->sortable(),
                Tables\Columns\IconColumn::make('readStatus')
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
                SelectFilter::make('readStatus')
                    ->multiple()
                    ->options([
                        '1' => 'Read',
                        '0' => 'Unread'
                    ])
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
            'index' => Pages\ListMessagings::route('/'),
            'create' => Pages\CreateMessaging::route('/create'),
            'edit' => Pages\EditMessaging::route('/{record}/edit'),
        ];
    }
}
