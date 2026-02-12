<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\DoughnutChartWidget;

class OrderStatusDistributionWidget extends DoughnutChartWidget
{
    protected ?string $heading = 'Orders by Status';
    
    protected static ?string $maxContentWidth = 'full';
    
    protected static ?int $sort = 12;

    protected function getData(): array
    {
        $data = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        '#6b7280',
                        '#3b82f6',
                        '#f59e0b',
                        '#10b981',
                        '#ef4444',
                    ],
                ],
            ],
            'labels' => ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
        ];
    }
}
