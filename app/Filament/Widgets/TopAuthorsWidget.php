<?php

namespace App\Filament\Widgets;

use App\Models\Author;
use Filament\Widgets\BarChartWidget;

class TopAuthorsWidget extends BarChartWidget
{
    protected ?string $heading = 'Most Published Authors';
    
    protected static ?string $maxContentWidth = 'full';
    
    protected static ?int $sort = 11;

    protected function getData(): array
    {
        $topAuthors = Author::withCount('books')
            ->orderByDesc('books_count')
            ->take(10)
            ->get();

        $labels = $topAuthors->map(fn ($author) => substr($author->name, 0, 12) . '...')->toArray();
        $data = $topAuthors->pluck('books_count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Books Written',
                    'data' => $data,
                    'backgroundColor' => '#06b6d4',
                    'borderColor' => '#0891b2',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
