<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use Filament\Widgets\BarChartWidget;

class TopSellingBooksWidget extends BarChartWidget
{
    protected ?string $heading = 'Top 10 Selling Books';
    
    protected static ?string $maxContentWidth = 'full';
    
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $topBooks = Book::withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(10)
            ->get();

        $labels = $topBooks->map(fn ($book) => substr($book->title, 0, 15) . '...')->toArray();
        $data = $topBooks->pluck('order_items_count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Units Sold',
                    'data' => $data,
                    'backgroundColor' => '#f59e0b',
                    'borderColor' => '#d97706',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
