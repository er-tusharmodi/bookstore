<?php

namespace App\Filament\Store\Resources\Inventories\Schemas;

use App\Support\SiteSettingStore;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InventoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('store_id')
                    ->default(fn () => auth()->user()?->store?->id),
                Select::make('book_id')
                    ->relationship('book', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('sku')
                    ->maxLength(255),
                TextInput::make('quantity')
                    ->numeric()
                    ->default(0),
                TextInput::make('price')
                    ->numeric()
                    ->prefix((string) SiteSettingStore::get('currency', 'USD')),
                TextInput::make('reorder_level')
                    ->numeric()
                    ->default(0),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->required()
                    ->default('active'),
            ]);
    }
}
