<?php

namespace App\Filament\Store\Resources\Orders\Schemas;

use App\Support\SiteSettingStore;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_number')
                    ->required()
                    ->maxLength(255),
                Select::make('user_id')
                    ->relationship('user', 'email')
                    ->searchable()
                    ->preload()
                    ->required(),
                Hidden::make('store_id')
                    ->default(fn () => auth()->user()?->store?->id),
                Select::make('status')
                    ->options([
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('processing'),
                TextInput::make('subtotal')
                    ->numeric()
                    ->default(0)
                    ->prefix((string) SiteSettingStore::get('currency', 'USD')),
                TextInput::make('shipping')
                    ->numeric()
                    ->default(0)
                    ->prefix((string) SiteSettingStore::get('currency', 'USD')),
                TextInput::make('tax')
                    ->numeric()
                    ->default(0)
                    ->prefix((string) SiteSettingStore::get('currency', 'USD')),
                TextInput::make('total')
                    ->numeric()
                    ->default(0)
                    ->prefix((string) SiteSettingStore::get('currency', 'USD')),
                DateTimePicker::make('placed_at'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
