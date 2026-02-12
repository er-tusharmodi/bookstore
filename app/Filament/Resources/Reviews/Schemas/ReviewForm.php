<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Review Information')
                    ->schema([
                        Select::make('book_id')
                            ->relationship('book', 'title')
                            ->required()
                            ->searchable(),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable(),
                        Select::make('rating')
                            ->options([
                                1 => '1 Star',
                                2 => '2 Stars',
                                3 => '3 Stars',
                                4 => '4 Stars',
                                5 => '5 Stars',
                            ])
                            ->required(),
                        TextInput::make('title')
                            ->maxLength(255),
                    ])->columns(2),
                Section::make('Review Content')
                    ->schema([
                        Textarea::make('comment')
                            ->columnSpanFull(),
                        Toggle::make('is_approved')
                            ->label('Approved')
                            ->default(false),
                    ]),
            ]);
    }
}
