<?php

namespace App\Filament\Widgets;

use App\Models\Review;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReviewStatsWidget extends BaseWidget
{
    protected static ?int $sort = 9;
    
    protected ?string $heading = 'Review Statistics';

    protected function getStats(): array
    {
        $totalReviews = Review::count();
        $approvedReviews = Review::where('is_approved', true)->count();
        $pendingReviews = Review::where('is_approved', false)->count();
        
        $avgRating = Review::avg('rating');
        
        $fiveStarCount = Review::where('rating', 5)->count();
        $oneStarCount = Review::where('rating', 1)->count();

        return [
            Stat::make('Total Reviews', $totalReviews)
                ->description('All reviews')
                ->descriptionIcon('heroicon-m-chat-bubble-bottom-center')
                ->color('info'),
            
            Stat::make('Approved', $approvedReviews)
                ->description('Published reviews')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            
            Stat::make('Pending Review', $pendingReviews)
                ->description('Awaiting moderation')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('warning'),
            
            Stat::make('Avg Rating', round($avgRating, 1) . '★')
                ->description('Customer satisfaction')
                ->descriptionIcon('heroicon-m-star')
                ->color('primary'),
        ];
    }
}
