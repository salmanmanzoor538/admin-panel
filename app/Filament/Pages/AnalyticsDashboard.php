<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\AnalyticsStatsWidget;
use App\Filament\Widgets\LineChartWidget;
use App\Filament\Widgets\BarChartWidget;
use App\Filament\Widgets\PieChartWidget;
use App\Filament\Widgets\AnalyticsOverviewWidget;

/**
 * Analytics Dashboard - Professional analytics dashboard with comprehensive metrics
 * Features: User analytics, traffic insights, conversion tracking, performance metrics
 */
class AnalyticsDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    
    protected static string $view = 'filament.pages.analytics-dashboard';
    
    protected static ?string $title = 'Analytics Dashboard';
    
    protected static ?string $navigationLabel = 'Analytics';
    
    protected static ?int $navigationSort = 1;
    
    protected static ?string $navigationGroup = 'Dashboards';
    
    public function getWidgets(): array
    {
        return [
            AnalyticsStatsWidget::class,
            AnalyticsOverviewWidget::class,
            LineChartWidget::class,
            BarChartWidget::class,
            PieChartWidget::class,
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