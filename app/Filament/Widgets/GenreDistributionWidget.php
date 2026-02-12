<?php

namespace App\Filament\Widgets;

use App\Models\Genre;
use Filament\Widgets\PieChartWidget;

class GenreDistributionWidget extends PieChartWidget
{
    protected ?string $heading = 'Books by Genre';
    
    protected static ?string $maxContentWidth = 'full';
    
    protected static ?int $sort = 7;

    protected function getData(): array
    {
        $genres = Genre::withCount('books')
            ->orderByDesc('books_count')
            ->take(8)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Number of Books',
                    'data' => $genres->pluck('books_count')->toArray(),
                    'backgroundColor' => [
                        '#ef4444',
                        '#f97316',
                        '#eab308',
                        '#22c55e',
                        '#06b6d4',
                        '#0ea5e9',
                        '#6366f1',
                        '#ec4899',
                    ],
                ],
            ],
            'labels' => $genres->pluck('name')->toArray(),
        ];
    }
}
