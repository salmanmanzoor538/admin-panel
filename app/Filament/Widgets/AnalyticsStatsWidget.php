<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

/**
 * Analytics Stats Widget - Comprehensive analytics overview
 * Features: User metrics, page views, bounce rate, session duration
 */
class AnalyticsStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        // Get real data from database
        $totalUsers = User::count();
        $newUsersThisMonth = User::where('created_at', '>=', now()->startOfMonth())->count();
        $totalPosts = Post::count();
        $publishedPosts = Post::where('status', 'published')->count();
        
        // Calculate growth percentages (mock data for demo)
        $userGrowth = $newUsersThisMonth > 0 ? round(($newUsersThisMonth / max($totalUsers - $newUsersThisMonth, 1)) * 100, 1) : 0;
        $postGrowth = $publishedPosts > 0 ? round(($publishedPosts / max($totalPosts - $publishedPosts, 1)) * 100, 1) : 0;
        
        return [
            Stat::make('Total Users', number_format($totalUsers))
                ->description($newUsersThisMonth . ' new this month')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
                
            Stat::make('Page Views', '89,432')
                ->description('12.5% increase from last month')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info')
                ->chart([15, 4, 10, 2, 12, 4, 12, 4])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
                
            Stat::make('Bounce Rate', '42.3%')
                ->description('2.1% decrease from last month')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('warning')
                ->chart([3, 4, 3, 5, 3, 4, 3, 4])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
                
            Stat::make('Avg. Session', '3m 24s')
                ->description('5.7% increase from last month')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
        ];
    }
}