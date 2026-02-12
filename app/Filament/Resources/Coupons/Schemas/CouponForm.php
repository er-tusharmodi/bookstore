<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Coupon Details')
                    ->schema([
                        TextInput::make('code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('e.g., SAVE20'),
                        Textarea::make('description')
                            ->helperText('Description for internal use'),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ]),
                Section::make('Discount Settings')
                    ->schema([
                        Select::make('discount_type')
                            ->options([
                                'percent' => 'Percentage',
                                'fixed' => 'Fixed Amount',
                            ])
                            ->required(),
                        TextInput::make('discount_value')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->helperText('Amount or percentage value'),
                        TextInput::make('min_purchase_amount')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->helperText('Minimum cart total required'),
                    ])->columns(2),
                Section::make('Usage Limits & Dates')
                    ->schema([
                        TextInput::make('max_usage')
                            ->numeric()
                            ->minValue(0)
                            ->helperText('Leave empty for unlimited uses'),
                        DateTimePicker::make('start_date')
                            ->helperText('When coupon becomes valid'),
                        DateTimePicker::make('expires_at')
                            ->helperText('When coupon expires'),
                    ])->columns(3),
            ]);
    }
}
