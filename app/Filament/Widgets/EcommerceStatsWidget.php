<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * E-commerce Stats Widget - Sales and revenue metrics
 * Features: Revenue tracking, order management, customer insights, conversion rates
 */
class EcommerceStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        // Mock e-commerce data - in a real application, this would come from orders, products, etc.
        $totalRevenue = 45678;
        $totalOrders = 1234;
        $totalCustomers = User::count();
        $conversionRate = 3.24;
        
        // Calculate growth percentages (mock data for demo)
        $revenueGrowth = 15.3;
        $ordersGrowth = 8.7;
        $customersGrowth = 12.1;
        $conversionGrowth = -0.8;
        
        return [
            Stat::make('Total Revenue', '$' . number_format($totalRevenue))
                ->description($revenueGrowth . '% increase from last month')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
                
            Stat::make('Total Orders', number_format($totalOrders))
                ->description($ordersGrowth . '% increase from last month')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info')
                ->chart([15, 4, 10, 2, 12, 4, 12, 4])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
                
            Stat::make('Customers', number_format($totalCustomers))
                ->description($customersGrowth . '% increase from last month')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
                
            Stat::make('Conversion Rate', $conversionRate . '%')
                ->description($conversionGrowth . '% decrease from last month')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('warning')
                ->chart([3, 4, 3, 5, 3, 4, 3, 4])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
        ];
    }
}