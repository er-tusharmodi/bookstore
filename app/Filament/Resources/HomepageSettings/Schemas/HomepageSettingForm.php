<?php

namespace App\Filament\Resources\HomepageSettings\Schemas;

use App\Models\Author;
use App\Models\Book;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class HomepageSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('hero_title')
                    ->maxLength(255),
                Textarea::make('hero_subtitle')
                    ->columnSpanFull(),
                Select::make('spotlight_book_id')
                    ->options(Book::query()->pluck('title', 'id'))
                    ->searchable()
                    ->nullable(),
                Select::make('featured_book_ids')
                    ->multiple()
                    ->options(Book::query()->pluck('title', 'id'))
                    ->searchable(),
                Select::make('more_book_ids')
                    ->multiple()
                    ->options(Book::query()->pluck('title', 'id'))
                    ->searchable(),
                Select::make('featured_author_ids')
                    ->multiple()
                    ->options(Author::query()->pluck('name', 'id'))
                    ->searchable(),
                TextInput::make('stats_books')
                    ->numeric(),
                TextInput::make('stats_authors')
                    ->numeric(),
                TextInput::make('stats_genres')
                    ->numeric(),
            ]);
    }
}
