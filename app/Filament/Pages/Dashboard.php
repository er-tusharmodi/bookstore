<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\OrdersChartWidget;
use App\Filament\Widgets\RevenueChartWidget;
use App\Filament\Widgets\TopSellingBooksWidget;
use App\Filament\Widgets\TopAuthorsWidget;
use App\Filament\Widgets\CustomerAcquisitionWidget;
use App\Filament\Widgets\GenreDistributionWidget;
use App\Filament\Widgets\ReviewStatsWidget;
use App\Filament\Widgets\RecentOrdersTableWidget;
use App\Filament\Widgets\LowStockAlertWidget;
use App\Filament\Widgets\ActiveCouponsWidget;
use App\Filament\Widgets\OrderStatusDistributionWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $routePath = '/';

    public function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
            OrdersChartWidget::class,
            RevenueChartWidget::class,
            OrderStatusDistributionWidget::class,
            TopSellingBooksWidget::class,
            TopAuthorsWidget::class,
            CustomerAcquisitionWidget::class,
            GenreDistributionWidget::class,
            ReviewStatsWidget::class,
            RecentOrdersTableWidget::class,
            LowStockAlertWidget::class,
            ActiveCouponsWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return [
            'md' => 3,
            'lg' => 3,
        ];
    }

    public function getFooterWidgetsColumns(): int | array
    {
        return 2;
    }
}
