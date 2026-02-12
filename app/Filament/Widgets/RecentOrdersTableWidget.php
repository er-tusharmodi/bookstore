<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrdersTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Orders';
    
    protected static ?string $maxContentWidth = 'full';
    
    protected static ?int $sort = 6;

    public function table(Table $table): Table
    {
        return $table
            ->query(Order::latest('created_at')->limit(10))
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->money()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'pending' => 'gray',
                        'processing' => 'info',
                        'shipped' => 'warning',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                    ])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('placed_at')
                    ->label('Order Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
