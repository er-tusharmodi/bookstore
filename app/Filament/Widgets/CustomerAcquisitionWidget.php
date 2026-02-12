<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\LineChartWidget;

class CustomerAcquisitionWidget extends LineChartWidget
{
    protected ?string $heading = 'Customer Growth';
    
    protected static ?string $maxContentWidth = 'full';
    
    protected static ?int $sort = 5;

    protected function getData(): array
    {
        $data = [];
        $labels = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $label = $date->format('M Y');
            $labels[] = $label;
            
            $count = User::role('customer')
                ->whereYear('created_at', '<=', $date->year)
                ->whereRaw("(YEAR(created_at) < ? OR (YEAR(created_at) = ? AND MONTH(created_at) <= ?))",
                    [$date->year, $date->year, $date->month])
                ->count();
            
            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Customers',
                    'data' => $data,
                    'borderColor' => '#8b5cf6',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                    'borderWidth' => 3,
                    'tension' => 0.4,
                    'fill' => true,
                    'pointBackgroundColor' => '#8b5cf6',
                    'pointBorderColor' => '#6d28d9',
                    'pointRadius' => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
