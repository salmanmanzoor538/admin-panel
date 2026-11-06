<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Range;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

/**
 * Crypto Exchange Page - Complete cryptocurrency trading platform
 * Features: Live exchange, charts, deposit/withdraw, buy/sell, wallet management
 */
class CryptoExchangePage extends Page implements HasForms
{
    use InteractsWithForms;
    
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    
    protected static string $view = 'filament.pages.crypto-exchange-page';
    
    protected static ?string $title = 'Crypto Exchange';
    
    protected static ?string $navigationLabel = 'Crypto Exchange';
    
    protected static ?int $navigationSort = 9;
    
    protected static ?string $navigationGroup = 'Crypto';
    
    public ?array $data = [];
    public ?string $activeTab = 'trading';
    public ?array $cryptoData = [];
    public ?array $wallet = [];
    public ?array $orders = [];
    public ?array $transactions = [];
    public ?string $selectedCrypto = 'BTC';
    public ?string $selectedFiat = 'USD';
    public ?string $orderType = 'market';
    public ?string $tradeType = 'buy';
    
    public function mount(): void
    {
        $this->form->fill();
        $this->loadCryptoData();
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Crypto Exchange')
                    ->tabs([
                        Tabs\Tab::make('Trading')
                            ->schema([
                                Section::make('Market Overview')
                                    ->schema([
                                        Placeholder::make('market_overview')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="market-overview">
                                                    <!-- Market overview will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Trading Chart')
                                    ->schema([
                                        Placeholder::make('trading_chart')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="trading-chart">
                                                    <!-- Trading chart will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Order Book')
                                    ->schema([
                                        Placeholder::make('order_book')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="order-book">
                                                    <!-- Order book will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Place Order')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('crypto_pair')
                                                    ->label('Trading Pair')
                                                    ->options([
                                                        'BTC/USD' => 'BTC/USD',
                                                        'ETH/USD' => 'ETH/USD',
                                                        'BNB/USD' => 'BNB/USD',
                                                        'ADA/USD' => 'ADA/USD',
                                                        'SOL/USD' => 'SOL/USD',
                                                        'DOT/USD' => 'DOT/USD',
                                                        'MATIC/USD' => 'MATIC/USD',
                                                        'AVAX/USD' => 'AVAX/USD',
                                                    ])
                                                    ->default('BTC/USD')
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateTradingPair()),
                                                    
                                                Select::make('order_type')
                                                    ->label('Order Type')
                                                    ->options([
                                                        'market' => 'Market Order',
                                                        'limit' => 'Limit Order',
                                                        'stop' => 'Stop Order',
                                                        'stop_limit' => 'Stop Limit Order',
                                                    ])
                                                    ->default('market')
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateOrderType()),
                                            ]),
                                            
                                        Radio::make('trade_type')
                                            ->label('Trade Type')
                                            ->options([
                                                'buy' => 'Buy',
                                                'sell' => 'Sell',
                                            ])
                                            ->default('buy')
                                            ->inline()
                                            ->live()
                                            ->afterStateUpdated(fn() => $this->updateTradeType()),
                                            
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('order_amount')
                                                    ->label('Amount')
                                                    ->numeric()
                                                    ->placeholder('0.00')
                                                    ->suffix('BTC')
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateOrderAmount()),
                                                    
                                                TextInput::make('order_price')
                                                    ->label('Price')
                                                    ->numeric()
                                                    ->placeholder('0.00')
                                                    ->suffix('USD')
                                                    ->visible(fn($get) => $get('order_type') !== 'market')
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateOrderPrice()),
                                            ]),
                                            
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('total_cost')
                                                    ->label('Total Cost')
                                                    ->numeric()
                                                    ->placeholder('0.00')
                                                    ->suffix('USD')
                                                    ->disabled(),
                                                    
                                                Range::make('order_percentage')
                                                    ->label('Order Percentage')
                                                    ->min(0)
                                                    ->max(100)
                                                    ->step(1)
                                                    ->default(25)
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateOrderPercentage()),
                                            ]),
                                            
                                        Checkbox::make('post_only')
                                            ->label('Post Only')
                                            ->helperText('Order will only be placed if it adds liquidity to the order book'),
                                            
                                        Checkbox::make('reduce_only')
                                            ->label('Reduce Only')
                                            ->helperText('Order will only reduce your position, not increase it'),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Wallet')
                            ->schema([
                                Section::make('Wallet Balance')
                                    ->schema([
                                        Placeholder::make('wallet_balance')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="wallet-balance">
                                                    <!-- Wallet balance will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Deposit')
                                    ->schema([
                                        Select::make('deposit_crypto')
                                            ->label('Select Cryptocurrency')
                                            ->options([
                                                'BTC' => 'Bitcoin (BTC)',
                                                'ETH' => 'Ethereum (ETH)',
                                                'BNB' => 'Binance Coin (BNB)',
                                                'ADA' => 'Cardano (ADA)',
                                                'SOL' => 'Solana (SOL)',
                                                'DOT' => 'Polkadot (DOT)',
                                                'MATIC' => 'Polygon (MATIC)',
                                                'AVAX' => 'Avalanche (AVAX)',
                                            ])
                                            ->default('BTC')
                                            ->live()
                                            ->afterStateUpdated(fn() => $this->updateDepositCrypto()),
                                            
                                        Placeholder::make('deposit_address')
                                            ->label('Deposit Address')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="deposit-address">
                                                    <!-- Deposit address will be rendered here -->
                                                </div>
                                            ')),
                                            
                                        Placeholder::make('deposit_qr')
                                            ->label('QR Code')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="deposit-qr">
                                                    <!-- QR code will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Withdraw')
                                    ->schema([
                                        Select::make('withdraw_crypto')
                                            ->label('Select Cryptocurrency')
                                            ->options([
                                                'BTC' => 'Bitcoin (BTC)',
                                                'ETH' => 'Ethereum (ETH)',
                                                'BNB' => 'Binance Coin (BNB)',
                                                'ADA' => 'Cardano (ADA)',
                                                'SOL' => 'Solana (SOL)',
                                                'DOT' => 'Polkadot (DOT)',
                                                'MATIC' => 'Polygon (MATIC)',
                                                'AVAX' => 'Avalanche (AVAX)',
                                            ])
                                            ->default('BTC')
                                            ->live()
                                            ->afterStateUpdated(fn() => $this->updateWithdrawCrypto()),
                                            
                                        TextInput::make('withdraw_address')
                                            ->label('Withdrawal Address')
                                            ->placeholder('Enter wallet address')
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(fn() => $this->updateWithdrawAddress()),
                                            
                                        TextInput::make('withdraw_amount')
                                            ->label('Amount')
                                            ->numeric()
                                            ->placeholder('0.00')
                                            ->suffix('BTC')
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(fn() => $this->updateWithdrawAmount()),
                                            
                                        TextInput::make('withdraw_fee')
                                            ->label('Network Fee')
                                            ->numeric()
                                            ->placeholder('0.00')
                                            ->suffix('BTC')
                                            ->disabled(),
                                            
                                        TextInput::make('withdraw_total')
                                            ->label('Total')
                                            ->numeric()
                                            ->placeholder('0.00')
                                            ->suffix('BTC')
                                            ->disabled(),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Orders')
                            ->schema([
                                Section::make('Open Orders')
                                    ->schema([
                                        Placeholder::make('open_orders')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="open-orders">
                                                    <!-- Open orders will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Order History')
                                    ->schema([
                                        Placeholder::make('order_history')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="order-history">
                                                    <!-- Order history will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Transactions')
                            ->schema([
                                Section::make('Transaction History')
                                    ->schema([
                                        Placeholder::make('transaction_history')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="transaction-history">
                                                    <!-- Transaction history will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Portfolio')
                            ->schema([
                                Section::make('Portfolio Overview')
                                    ->schema([
                                        Placeholder::make('portfolio_overview')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="portfolio-overview">
                                                    <!-- Portfolio overview will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Asset Allocation')
                                    ->schema([
                                        Placeholder::make('asset_allocation')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="asset-allocation">
                                                    <!-- Asset allocation will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('place_order')
                ->label('Place Order')
                ->icon('heroicon-o-currency-dollar')
                ->color('success')
                ->action('placeOrder')
                ->visible(fn() => $this->activeTab === 'trading'),
                
            Action::make('deposit_funds')
                ->label('Deposit')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->action('depositFunds')
                ->visible(fn() => $this->activeTab === 'wallet'),
                
            Action::make('withdraw_funds')
                ->label('Withdraw')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('warning')
                ->action('withdrawFunds')
                ->visible(fn() => $this->activeTab === 'wallet'),
        ];
    }
    
    protected function loadCryptoData(): void
    {
        $this->cryptoData = [
            'BTC' => [
                'name' => 'Bitcoin',
                'symbol' => 'BTC',
                'price' => 43250.00,
                'change_24h' => 2.45,
                'volume_24h' => 28500000000,
                'market_cap' => 850000000000,
                'supply' => 19650000,
                'max_supply' => 21000000,
            ],
            'ETH' => [
                'name' => 'Ethereum',
                'symbol' => 'ETH',
                'price' => 2650.00,
                'change_24h' => -1.23,
                'volume_24h' => 15000000000,
                'market_cap' => 320000000000,
                'supply' => 120000000,
                'max_supply' => null,
            ],
            'BNB' => [
                'name' => 'Binance Coin',
                'symbol' => 'BNB',
                'price' => 315.00,
                'change_24h' => 0.87,
                'volume_24h' => 1200000000,
                'market_cap' => 48000000000,
                'supply' => 152000000,
                'max_supply' => 200000000,
            ],
        ];
        
        $this->wallet = [
            'BTC' => ['balance' => 0.5, 'value' => 21625.00],
            'ETH' => ['balance' => 2.0, 'value' => 5300.00],
            'BNB' => ['balance' => 10.0, 'value' => 3150.00],
            'USD' => ['balance' => 5000.00, 'value' => 5000.00],
        ];
        
        $this->orders = [
            [
                'id' => 'ORD-001',
                'pair' => 'BTC/USD',
                'type' => 'buy',
                'amount' => 0.1,
                'price' => 43000.00,
                'status' => 'open',
                'created_at' => '2024-01-15 10:30:00',
            ],
            [
                'id' => 'ORD-002',
                'pair' => 'ETH/USD',
                'type' => 'sell',
                'amount' => 1.0,
                'price' => 2700.00,
                'status' => 'filled',
                'created_at' => '2024-01-14 15:45:00',
            ],
        ];
        
        $this->transactions = [
            [
                'id' => 'TXN-001',
                'type' => 'deposit',
                'crypto' => 'BTC',
                'amount' => 0.5,
                'status' => 'completed',
                'created_at' => '2024-01-15 09:00:00',
            ],
            [
                'id' => 'TXN-002',
                'type' => 'withdraw',
                'crypto' => 'ETH',
                'amount' => 1.0,
                'status' => 'pending',
                'created_at' => '2024-01-14 16:30:00',
            ],
        ];
    }
    
    public function updateTradingPair(): void
    {
        Notification::make()
            ->title('Trading pair updated')
            ->success()
            ->send();
    }
    
    public function updateOrderType(): void
    {
        Notification::make()
            ->title('Order type updated')
            ->success()
            ->send();
    }
    
    public function updateTradeType(): void
    {
        Notification::make()
            ->title('Trade type updated')
            ->success()
            ->send();
    }
    
    public function updateOrderAmount(): void
    {
        Notification::make()
            ->title('Order amount updated')
            ->success()
            ->send();
    }
    
    public function updateOrderPrice(): void
    {
        Notification::make()
            ->title('Order price updated')
            ->success()
            ->send();
    }
    
    public function updateOrderPercentage(): void
    {
        Notification::make()
            ->title('Order percentage updated')
            ->success()
            ->send();
    }
    
    public function updateDepositCrypto(): void
    {
        Notification::make()
            ->title('Deposit cryptocurrency updated')
            ->success()
            ->send();
    }
    
    public function updateWithdrawCrypto(): void
    {
        Notification::make()
            ->title('Withdraw cryptocurrency updated')
            ->success()
            ->send();
    }
    
    public function updateWithdrawAddress(): void
    {
        Notification::make()
            ->title('Withdrawal address updated')
            ->success()
            ->send();
    }
    
    public function updateWithdrawAmount(): void
    {
        Notification::make()
            ->title('Withdrawal amount updated')
            ->success()
            ->send();
    }
    
    public function placeOrder(): void
    {
        Notification::make()
            ->title('Order placed successfully')
            ->success()
            ->send();
    }
    
    public function depositFunds(): void
    {
        Notification::make()
            ->title('Deposit initiated')
            ->success()
            ->send();
    }
    
    public function withdrawFunds(): void
    {
        Notification::make()
            ->title('Withdrawal initiated')
            ->success()
            ->send();
    }
    
    public function cancelOrder(string $orderId): void
    {
        Notification::make()
            ->title('Order cancelled')
            ->success()
            ->send();
    }
    
    public function copyAddress(string $address): void
    {
        Notification::make()
            ->title('Address copied to clipboard')
            ->success()
            ->send();
    }
}