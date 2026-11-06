<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\EcommerceStatsWidget;
use App\Filament\Widgets\SalesChartWidget;
use App\Filament\Widgets\RevenueWidget;
use App\Filament\Widgets\TopProductsWidget;
use App\Filament\Widgets\RecentOrdersWidget;
use App\Filament\Widgets\CustomerInsightsWidget;

/**
 * E-commerce Dashboard - Complete e-commerce analytics and management
 * Features: Sales tracking, revenue analytics, product performance, order management
 */
class EcommerceDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    
    protected static string $view = 'filament.pages.ecommerce-dashboard';
    
    protected static ?string $title = 'E-commerce Dashboard';
    
    protected static ?string $navigationLabel = 'E-commerce';
    
    protected static ?int $navigationSort = 2;
    
    protected static ?string $navigationGroup = 'Dashboards';
    
    public function getWidgets(): array
    {
        return [
            EcommerceStatsWidget::class,
            SalesChartWidget::class,
            RevenueWidget::class,
            TopProductsWidget::class,
            RecentOrdersWidget::class,
            CustomerInsightsWidget::class,
        ];
    }
    
    public function getColumns(): int | string | array
    {
        return [
            'md' => 2,
            'xl' => 3,
        ];
    }
}