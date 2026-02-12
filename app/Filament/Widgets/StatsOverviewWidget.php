<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Book;
use App\Models\User;
use App\Models\Review;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRevenue = Order::where('status', '!=', 'cancelled')
            ->sum('total');
        
        $totalOrders = Order::where('status', '!=', 'cancelled')->count();
        
        $totalBooks = Book::count();
        
        $totalCustomers = User::role('customer')->count();
        
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        $pendingOrders = Order::where('status', 'pending')->count();
        
        $totalReviews = Review::count();
        
        $approvedReviews = Review::where('is_approved', true)->count();

        return [
            Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
                ->description('All time earnings')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            
            Stat::make('Total Orders', $totalOrders)
                ->description('Completed & Processing')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),
            
            Stat::make('Avg Order Value', '$' . number_format($avgOrderValue, 2))
                ->description('Average per order')
                ->descriptionIcon('heroicon-m-calculator')
                ->color('warning'),
            
            Stat::make('Total Books', $totalBooks)
                ->description('Items in catalog')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('primary'),
            
            Stat::make('Total Customers', $totalCustomers)
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('secondary'),
            
            Stat::make('Pending Orders', $pendingOrders)
                ->description('Awaiting processing')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'),
        ];
    }
}
