<?php

namespace App\Filament\Resources\Inventories\Tables;

use App\Support\SiteSettingStore;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InventoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('store.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('book.title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sku')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->badge()
                    ->color(fn ($state, $record): string => 
                        $state <= $record->reorder_level ? 'danger' : 'success'
                    )
                    ->sortable(),
                TextColumn::make('price')
                    ->money((string) SiteSettingStore::get('currency', 'USD'))
                    ->sortable(),
                TextColumn::make('reorder_level')
                    ->label('Reorder Level'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                        'discontinued' => 'danger',
                    })
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'discontinued' => 'Discontinued',
                    ]),
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
