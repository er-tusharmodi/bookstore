<?php

namespace App\Filament\Resources\Formats;

use App\Filament\Resources\Formats\Pages\CreateFormat;
use App\Filament\Resources\Formats\Pages\EditFormat;
use App\Filament\Resources\Formats\Pages\ListFormats;
use App\Filament\Resources\Formats\Schemas\FormatForm;
use App\Filament\Resources\Formats\Tables\FormatsTable;
use App\Models\Format;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FormatResource extends Resource
{
    protected static ?string $model = Format::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return FormatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FormatsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFormats::route('/'),
            'create' => CreateFormat::route('/create'),
            'edit' => EditFormat::route('/{record}/edit'),
        ];
    }
}
