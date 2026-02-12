<?php

namespace App\Filament\Widgets;

use App\Models\Inventory;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockAlertWidget extends BaseWidget
{
    protected static ?string $heading = 'Low Stock Alert';
    
    protected static ?string $maxContentWidth = 'full';
    
    protected static ?int $sort = 8;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Inventory::where('status', 'active')
                    ->whereRaw('quantity <= reorder_level')
                    ->latest('updated_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('book.title')
                    ->label('Book')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('store.name')
                    ->label('Store')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sku')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('quantity')
                    ->color('danger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reorder_level')
                    ->label('Reorder Level')
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
