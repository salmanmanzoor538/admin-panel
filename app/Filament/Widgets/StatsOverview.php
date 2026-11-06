<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Post;
use App\Models\Page;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            
            Stat::make('Published Posts', Post::published()->count())
                ->description('Blog posts')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
            
            Stat::make('Published Pages', Page::published()->count())
                ->description('Static pages')
                ->descriptionIcon('heroicon-m-document')
                ->color('info'),
            
            Stat::make('Categories', Category::active()->count())
                ->description('Content categories')
                ->descriptionIcon('heroicon-m-tag')
                ->color('warning'),
            
            Stat::make('Draft Posts', Post::where('status', 'draft')->count())
                ->description('Unpublished posts')
                ->descriptionIcon('heroicon-m-pencil-square')
                ->color('gray'),
            
            Stat::make('Active Users', User::active()->count())
                ->description('Currently active')
                ->descriptionIcon('heroicon-m-user-check')
                ->color('success'),
        ];
    }
}