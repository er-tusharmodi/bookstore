<?php

namespace App\Filament\Resources\Inventories\Schemas;

use App\Support\SiteSettingStore;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InventoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Stock Information')
                    ->schema([
                        Select::make('store_id')
                            ->relationship('store', 'name')
                            ->required()
                            ->searchable(),
                        Select::make('book_id')
                            ->relationship('book', 'title')
                            ->required()
                            ->searchable(),
                        TextInput::make('sku')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Stock Keeping Unit'),
                    ])->columns(3),
                Section::make('Quantity & Pricing')
                    ->schema([
                        TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix((string) SiteSettingStore::get('currency', 'USD')),
                        TextInput::make('reorder_level')
                            ->numeric()
                            ->minValue(0)
                            ->helperText('Alert when stock falls below this level'),
                    ])->columns(3),
                Section::make('Status')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'discontinued' => 'Discontinued',
                            ])
                            ->required(),
                    ]),
            ]);
    }
}
