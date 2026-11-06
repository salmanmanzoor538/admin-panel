<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\CryptoStatsWidget;
use App\Filament\Widgets\CryptoChartWidget;
use App\Filament\Widgets\PortfolioWidget;
use App\Filament\Widgets\MarketOverviewWidget;
use App\Filament\Widgets\TradingHistoryWidget;
use App\Filament\Widgets\WalletBalanceWidget;

/**
 * Crypto Dashboard - Advanced cryptocurrency trading and portfolio management
 * Features: Live exchange rates, portfolio tracking, trading history, market analysis
 */
class CryptoDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    
    protected static string $view = 'filament.pages.crypto-dashboard';
    
    protected static ?string $title = 'Crypto Dashboard';
    
    protected static ?string $navigationLabel = 'Crypto';
    
    protected static ?int $navigationSort = 3;
    
    protected static ?string $navigationGroup = 'Dashboards';
    
    public function getWidgets(): array
    {
        return [
            CryptoStatsWidget::class,
            CryptoChartWidget::class,
            PortfolioWidget::class,
            MarketOverviewWidget::class,
            TradingHistoryWidget::class,
            WalletBalanceWidget::class,
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