<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use App\Models\User;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Information')
                    ->schema([
                        TextInput::make('order_number')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable(),
                        Select::make('store_id')
                            ->relationship('store', 'name')
                            ->searchable(),
                        DateTimePicker::make('placed_at')
                            ->default(now()),
                    ])->columns(2),
                Section::make('Order Amount')
                    ->schema([
                        TextInput::make('subtotal')
                            ->required()
                            ->numeric()
                            ->default(0.0),
                        TextInput::make('shipping')
                            ->required()
                            ->numeric()
                            ->default(0.0),
                        TextInput::make('tax')
                            ->required()
                            ->numeric()
                            ->default(0.0),
                        TextInput::make('total')
                            ->required()
                            ->numeric()
                            ->default(0.0),
                    ])->columns(2),
                Section::make('Order Status & Notes')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                        Textarea::make('notes')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
