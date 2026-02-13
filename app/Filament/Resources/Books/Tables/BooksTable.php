<?php

namespace App\Filament\Resources\Books\Tables;

use App\Support\SiteSettingStore;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BooksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('author.name')
                    ->label('Author')
                    ->searchable(),
                TextColumn::make('genreRelation.name')
                    ->label('Genre')
                    ->formatStateUsing(fn ($record) => $record->genreRelation?->name ?? $record->genre)
                    ->searchable(),
                TextColumn::make('formatRelation.name')
                    ->label('Format')
                    ->formatStateUsing(fn ($record) => $record->formatRelation?->name ?? $record->format)
                    ->searchable(),
                TextColumn::make('price')
                    ->money((string) SiteSettingStore::get('currency', 'USD'))
                    ->sortable(),
                TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('published_year')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('is_featured')
                    ->label('Featured')
                    ->badge(),
                TextColumn::make('is_deal')
                    ->label('Deal')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
