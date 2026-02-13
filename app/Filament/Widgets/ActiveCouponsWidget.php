<?php

namespace App\Filament\Widgets;

use App\Models\Coupon;
use App\Support\SiteSettingStore;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Carbon\Carbon;

class ActiveCouponsWidget extends BaseWidget
{
    protected static ?string $heading = 'Active Coupons';
    
    protected static ?string $maxContentWidth = 'full';
    
    protected static ?int $sort = 10;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Coupon::where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                            ->orWhere('expires_at', '>', Carbon::now());
                    })
                    ->latest('created_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\BadgeColumn::make('discount_type')
                    ->colors([
                        'percent' => 'warning',
                        'fixed' => 'success',
                    ])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_value')
                    ->formatStateUsing(fn ($state, $record) => 
                        $record->discount_type === 'percent'
                            ? $state . '%'
                            : (string) SiteSettingStore::get('currency', 'USD') . ' ' . $state
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('times_used')
                    ->label('Uses')
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_usage')
                    ->label('Max')
                    ->sortable(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime()
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
