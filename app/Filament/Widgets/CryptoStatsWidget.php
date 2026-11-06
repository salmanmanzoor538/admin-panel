<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * Crypto Stats Widget - Cryptocurrency portfolio and market metrics
 * Features: Portfolio value, daily changes, coin count, ROI tracking
 */
class CryptoStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        // Mock crypto data - in a real application, this would come from crypto APIs
        $portfolioValue = 45678;
        $dailyChange = 2345;
        $totalCoins = 12;
        $roi = 24.8;
        
        // Calculate growth percentages (mock data for demo)
        $portfolioGrowth = 12.5;
        $dailyGrowth = 5.4;
        $roiGrowth = 24.8;
        
        return [
            Stat::make('Portfolio Value', '$' . number_format($portfolioValue))
                ->description('+' . $portfolioGrowth . '% from last month')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
                
            Stat::make('24h Change', '+' . '$' . number_format($dailyChange))
                ->description('+' . $dailyGrowth . '% from yesterday')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([15, 4, 10, 2, 12, 4, 12, 4])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
                
            Stat::make('Total Coins', $totalCoins)
                ->description('Active in portfolio')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('info')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
                
            Stat::make('ROI', '+' . $roi . '%')
                ->description('All time return')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([3, 4, 3, 5, 3, 4, 3, 4])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
        ];
    }
}