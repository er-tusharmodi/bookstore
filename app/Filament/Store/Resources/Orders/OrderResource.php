<?php

namespace App\Filament\Store\Resources\Orders;

use App\Filament\Store\Resources\Orders\Pages\CreateOrder;
use App\Filament\Store\Resources\Orders\Pages\EditOrder;
use App\Filament\Store\Resources\Orders\Pages\ListOrders;
use App\Filament\Store\Resources\Orders\Schemas\OrderForm;
use App\Filament\Store\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use BackedEnum;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
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
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
