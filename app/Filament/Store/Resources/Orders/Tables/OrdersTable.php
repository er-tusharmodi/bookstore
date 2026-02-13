<?php

namespace App\Filament\Store\Resources\Orders\Tables;

use App\Support\SiteSettingStore;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('Customer')
                    ->searchable(),
                SelectColumn::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->selectablePlaceholder(false)
                    ->width('150px'),
                TextColumn::make('total')
                    ->money((string) SiteSettingStore::get('currency', 'USD'))
                    ->sortable(),
                TextColumn::make('placed_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordClasses(fn ($record) => match ($record->status) {
                'pending' => 'order-status-pending',
                'processing' => 'order-status-processing',
                'shipped' => 'order-status-shipped',
                'delivered' => 'order-status-delivered',
                'cancelled' => 'order-status-cancelled',
                default => '',
            })
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
