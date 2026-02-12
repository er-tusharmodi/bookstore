<?php

namespace App\Filament\Author\Resources\Books\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('author_id')
                    ->default(fn () => auth()->user()?->author?->id),
                Select::make('genre_id')
                    ->relationship('genreRelation', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Select::make('format_id')
                    ->relationship('formatRelation', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('genre')
                    ->maxLength(255),
                TextInput::make('format')
                    ->maxLength(255),
                TextInput::make('price')
                    ->numeric()
                    ->default(0),
                TextInput::make('published_year')
                    ->numeric(),
                TextInput::make('rating')
                    ->numeric()
                    ->default(0),
                TextInput::make('cover_tone')
                    ->maxLength(255),
                Textarea::make('blurb')
                    ->columnSpanFull(),
                TextInput::make('meta_title')
                    ->maxLength(255),
                Textarea::make('meta_description')
                    ->columnSpanFull(),
                TextInput::make('meta_keywords')
                    ->maxLength(255),
                Toggle::make('is_featured')
                    ->default(false),
                Toggle::make('is_deal')
                    ->default(false),
            ]);
    }
}
