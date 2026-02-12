<?php

namespace App\Filament\Store\Resources\Inventories;

use App\Filament\Store\Resources\Inventories\Pages\CreateInventory;
use App\Filament\Store\Resources\Inventories\Pages\EditInventory;
use App\Filament\Store\Resources\Inventories\Pages\ListInventories;
use App\Filament\Store\Resources\Inventories\Schemas\InventoryForm;
use App\Filament\Store\Resources\Inventories\Tables\InventoriesTable;
use App\Models\Inventory;
use BackedEnum;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return InventoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $storeId = auth()->user()?->store?->id;

        return parent::getEloquentQuery()
            ->when($storeId, fn (Builder $query) => $query->where('store_id', $storeId));
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInventories::route('/'),
            'create' => CreateInventory::route('/create'),
            'edit' => EditInventory::route('/{record}/edit'),
        ];
    }
}
