<?php

namespace App\Filament\Author\Resources\Books;

use App\Filament\Author\Resources\Books\Pages\CreateBook;
use App\Filament\Author\Resources\Books\Pages\EditBook;
use App\Filament\Author\Resources\Books\Pages\ListBooks;
use App\Filament\Author\Resources\Books\Schemas\BookForm;
use App\Filament\Author\Resources\Books\Tables\BooksTable;
use App\Models\Book;
use BackedEnum;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return BookForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BooksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $authorId = auth()->user()?->author?->id;

        return parent::getEloquentQuery()
            ->when($authorId, fn (Builder $query) => $query->where('author_id', $authorId));
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBooks::route('/'),
            'create' => CreateBook::route('/create'),
            'edit' => EditBook::route('/{record}/edit'),
        ];
    }
}
