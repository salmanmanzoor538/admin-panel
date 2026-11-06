<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Post;
use App\Models\Page;
use App\Models\Category;
use App\Modules\Ecommerce\Models\Product;
use App\Modules\Ecommerce\Models\Order;
use App\Modules\LMS\Models\Course;
use App\Modules\LMS\Models\CourseEnrollment;
use App\Modules\CRM\Models\Client;
use App\Modules\CRM\Models\Deal;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class AdvancedStatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $stats = [];

        // Core Platform Stats
        $stats[] = Stat::make('Total Users', User::count())
            ->description('Registered users')
            ->descriptionIcon('heroicon-m-users')
            ->color('success')
            ->chart($this->getUserGrowthChart());

        $stats[] = Stat::make('Published Posts', Post::published()->count())
            ->description('Blog articles')
            ->descriptionIcon('heroicon-m-document-text')
            ->color('primary')
            ->chart($this->getPostsChart());

        $stats[] = Stat::make('Published Pages', Page::published()->count())
            ->description('Static pages')
            ->descriptionIcon('heroicon-m-document')
            ->color('info')
            ->chart($this->getPagesChart());

        // E-commerce Stats (if module enabled)
        if (config('modules.ecommerce.enabled', true)) {
            $stats[] = Stat::make('Total Products', Product::published()->count())
                ->description('Active products')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning')
                ->chart($this->getProductsChart());

            $stats[] = Stat::make('Total Orders', Order::count())
                ->description('All time orders')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('success')
                ->chart($this->getOrdersChart());

            $stats[] = Stat::make('Revenue', '$' . number_format(Order::where('status', 'delivered')->sum('total_amount'), 2))
                ->description('Total revenue')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success')
                ->chart($this->getRevenueChart());
        }

        // LMS Stats (if module enabled)
        if (config('modules.lms.enabled', true)) {
            $stats[] = Stat::make('Total Courses', Course::published()->count())
                ->description('Published courses')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary')
                ->chart($this->getCoursesChart());

            $stats[] = Stat::make('Total Enrollments', CourseEnrollment::count())
                ->description('Course enrollments')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('success')
                ->chart($this->getEnrollmentsChart());
        }

        // CRM Stats (if module enabled)
        if (config('modules.crm.enabled', true)) {
            $stats[] = Stat::make('Total Clients', Client::count())
                ->description('All clients')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('info')
                ->chart($this->getClientsChart());

            $stats[] = Stat::make('Active Deals', Deal::whereIn('status', ['open', 'qualified', 'proposal'])->count())
                ->description('Pipeline deals')
                ->descriptionIcon('heroicon-m-hand-raised')
                ->color('warning')
                ->chart($this->getDealsChart());
        }

        return $stats;
    }

    protected function getUserGrowthChart(): array
    {
        $data = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $data->pluck('count')->toArray();
    }

    protected function getPostsChart(): array
    {
        $data = Post::selectRaw('DATE(published_at) as date, COUNT(*) as count')
            ->where('published_at', '>=', now()->subDays(30))
            ->where('status', 'published')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $data->pluck('count')->toArray();
    }

    protected function getPagesChart(): array
    {
        $data = Page::selectRaw('DATE(published_at) as date, COUNT(*) as count')
            ->where('published_at', '>=', now()->subDays(30))
            ->where('status', 'published')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $data->pluck('count')->toArray();
    }

    protected function getProductsChart(): array
    {
        if (!config('modules.ecommerce.enabled', true)) {
            return [];
        }

        $data = Product::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $data->pluck('count')->toArray();
    }

    protected function getOrdersChart(): array
    {
        if (!config('modules.ecommerce.enabled', true)) {
            return [];
        }

        $data = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $data->pluck('count')->toArray();
    }

    protected function getRevenueChart(): array
    {
        if (!config('modules.ecommerce.enabled', true)) {
            return [];
        }

        $data = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->where('created_at', '>=', now()->subDays(30))
            ->where('status', 'delivered')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $data->pluck('revenue')->toArray();
    }

    protected function getCoursesChart(): array
    {
        if (!config('modules.lms.enabled', true)) {
            return [];
        }

        $data = Course::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $data->pluck('count')->toArray();
    }

    protected function getEnrollmentsChart(): array
    {
        if (!config('modules.lms.enabled', true)) {
            return [];
        }

        $data = CourseEnrollment::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $data->pluck('count')->toArray();
    }

    protected function getClientsChart(): array
    {
        if (!config('modules.crm.enabled', true)) {
            return [];
        }

        $data = Client::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $data->pluck('count')->toArray();
    }

    protected function getDealsChart(): array
    {
        if (!config('modules.crm.enabled', true)) {
            return [];
        }

        $data = Deal::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->whereIn('status', ['open', 'qualified', 'proposal'])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $data->pluck('count')->toArray();
    }
}